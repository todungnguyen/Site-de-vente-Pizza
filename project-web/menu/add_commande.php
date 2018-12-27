<?php
session_start();

$title = "Payement";

include("header.php");
?>

<div id="container">

	<?php
	if(!isset($_SESSION['login'])) {
		?>
		Veillez <a href="../login/login_form.php">connecter</a> pour continuer votre d'achat.<br><br>
		<?php

	} else {

		function rand_string( $length ) {
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$str = "";
			$size = strlen($chars);
			for( $i = 0; $i < $length; $i++ ) {
				$str .= $chars[ rand( 0, $size - 1 ) ];
			}
			return $str;
		}

		$uid = $_SESSION['uid'];

		$letter = rand_string(6);

		$date = date("Y-m-d h:i:s");

		if(!isset($_SESSION['recette']) && !isset($_SESSION['supplement'])) {
			echo "Votre panier est vide.<br>";
		} 

		else {

			try {

				require("../db_config.php");

				if(isset($_SESSION['recette'])) {

					$rpt = 0;

					while($rpt <= $_SESSION['rpt']) {

						if(isset($_SESSION['recette'][$rpt])) {

							foreach($_SESSION['recette'][$rpt] as $id => $value) { 
								if($id == 'rid') {
									$rid = $value;
								}
							}


							$SQL = "INSERT INTO commandes(ref,uid,rid,date) VALUES (?,?,?,?)"; 
							$st = $db->prepare($SQL);
							$st->execute(array($letter,$uid,$rid,$date));

							unset($_SESSION['recette'][$rpt]); 

							if(empty($_SESSION['recette'])) {
								unset($_SESSION['recette']);
							}

							$SQL = "SELECT * FROM commandes WHERE cid = (SELECT MAX(cid) FROM commandes)"; 
							$st = $db->prepare($SQL);
							$st->execute();

							$result = $st->fetchAll(PDO::FETCH_ASSOC);

							foreach ($result as $row) { 
								$cid = $row['cid'];
							}

							if(isset($_SESSION['supplement'][$rpt])) {
								$SQL = "SELECT * FROM supplements WHERE sid IN(";

								foreach($_SESSION['supplement'][$rpt] as $sid => $value) {
									$SQL.=$sid.",";
								}

								$SQL = substr($SQL,0,-1).")";

								$res = $db->query($SQL);

								foreach($res as $row) {
									$SQL = "INSERT INTO extras VALUES (?,?)"; 
									$st = $db->prepare($SQL);
									$result = $st->execute(array($cid,$row['sid']));
								}

								if (!$res) {
									echo "Erreur de connection.";
								}
								else {
									unset($_SESSION['supplement'][$rpt]);

									if(empty($_SESSION['supplement'])) {
										unset($_SESSION['supplement']);
									}
								}
							}
						}
						$rpt++;
					}
				}

				$db=null;
			}

			catch (PDOException $e) {
				echo "Erreur SQL: ".$e->getMessage(); 
			}

			echo "Votre commande dont la référence: ".$letter." a été prise en compte.<br>"; 
		}
	}
	?>
	<br>
	<a href='../index.php'>Revenir</a> à la page d'accueil
</div>

<?php
include("footer.php");
?>







