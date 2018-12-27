<?php
session_start();
?>

<?php

$page_title = "Espace Client";

include("header.php");

?>

<link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body>

	<div id="client">
		
		<?php

		if(isset($_SESSION['uid'])) {

			$uid = $_SESSION['uid'];

			try {
				
				require("../db_config.php");

				$SQL = "SELECT COUNT(*) FROM commandes WHERE uid = $uid";
				$st = $db->prepare($SQL);
				$st->execute();

				$number = $st->fetchColumn();

				if($number == 0) {
					echo "Vous avez fait aucun d'achat.<br>";
					
					echo '<p><a href="../menu/produit.php">Commencez</a> votre premier d\'achat.</p>';
				}
				else {
					$SQL = "SELECT * FROM commandes WHERE uid = $uid";
					$res = $db->query($SQL);
					?>
					<h3>Liste des achats effectués: </h3>
					<table>
						<tr>
							<th>ref</th>
							<th>date</th>
							<th>prix total</th>
						</tr>

						<?php
						foreach($res as $row) {
							?>

							<tr>
								<td><a href="facture.php?ref=<?php echo $row['ref'] ?>&cid=<?php echo $row['cid'] ?>"><?php echo $row['ref'] ?></a></td>
								<td><?php echo $row['date'] ?></td>

								<td>
									<?php
									$rid = $row['rid'];
									$prix_rid = 0;
									$prix_sid = 0;
									if(isset($array_sid)) {
										unset($array_sid);
									}
									$i = 0;

									$SQL1 = "SELECT * FROM recettes WHERE rid = $rid";
									$res1 = $db->query($SQL1);

									foreach($res1 as $row1) {
										$prix_rid = $row1['prix'];
									}

									$cid = $row['cid'];
									$SQL2 = "SELECT COUNT(*) FROM extras WHERE cid = $cid";
									$st = $db->prepare($SQL2);
									$st->execute();

									$number = $st->fetchColumn();

									if($number != 0) {
										$SQL2 = "SELECT * FROM extras WHERE cid = $cid";
										$st = $db->prepare($SQL2);
										$st->execute();

										$res2 = $st->fetchAll(PDO::FETCH_ASSOC);

										foreach($res2 as $row2) {
											$array_sid[$i] = $row2['sid'];
											$i++;
										}


										$SQL3 = "SELECT * FROM supplements WHERE sid IN(";
										foreach($array_sid as $sid => $value) {
											$SQL3.=$value.",";
										}

										$SQL3 = substr($SQL3,0,-1).")";

										$res3 = $db->query($SQL3);

										foreach($res3 as $row3) {
											$prix_sid = $prix_sid + $row3['prix'];
										}
									}

									$total = $prix_sid + $prix_rid;

									echo $total."€";
									?>
								</td>
							</tr>

							<?php } ?>
						</table>
						<?php
					}
					$db = null; 
				}

				catch (PDOException $e) {
					echo "Erreur SQL: ".$e->getMessage(); 
				}

				?>
				<br>
				<a href='../index.php'>Revenir</a> à la page d'accueil
				<?php
			} else {
				echo 'Veillez <a href="login.php">connecter</a> d\'abord.<br>';
			}
			?> 
		</div> 
		<?php
		include "footer.php";
		?>
