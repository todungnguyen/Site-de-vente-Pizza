<?php
session_start();
$page_title="Modifier produit"; 
include("header.php");

?>
<div id="container">
	<?php
	if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {
		if (!isset($_GET["sid"])) {
			echo "<p class='alert'>Erreur<p>";

		} else {
			$test = 0;
			$sid = $_GET["sid"];

			try {

				require(__DIR__ ."/../../db_config.php");

				$SQL = "SELECT * FROM supplements WHERE sid = ?";
				$st = $db->prepare($SQL);
				$res = $st->execute(array($sid));

				if ($st->rowCount() ==0) {
					echo "<p class='alert'>Erreur de sid</p>";

				} else if (!isset($_POST['nom']) || !isset($_POST['prix']) ) {
					include("mod_form.php"); 

				} else {  
					$nom = $_POST['nom']; 
					$prix=  $_POST['prix']; 

					if ($nom=="" || !is_numeric($prix) || $prix<0) {
						include("mod_form.php");   

					} else {

						$SQL = "SELECT * FROM supplements";
						$res = $db->query($SQL);

						foreach($res as $row) {
							if ($row['nom'] == $nom) {
								echo "<p class='alert'>Ce produit déjà existant.</p>";
								echo "Produit ".$row['nom'].", prix: ".$row['prix'].".<br>";
								?>

								<p>Voulez-vous le modifier?</p>
								<a href="mod.php?sid=<?php echo $row['sid']?>">Oui</a>
								<a href="liste.php">Non</a>
								<br>

								<?php

								$test = 1;
							}
						}

						if($test == 0) {

							$SQL ="UPDATE supplements SET nom=?, prix=? WHERE sid=? ";
							$st = $db->prepare($SQL);
							$res = $st->execute(array($nom, $prix, $sid));

							if (!$res) {
								echo "<p class='alert'>Erreur de modification</p>";
							} else echo "<p>La modification a été effectuée</p>";
						}
					}

					$db=null;
				}
			} catch (PDOException $e) {
				echo "Erreur SQL: ".$e->getMessage();
			}
		}

		?>

		<a href="liste.php">Liste</a> des suppléments
		<br>
		<a href='../../index.php'>Revenir</a> à la page d'accueil

		<?php
	} else {
		echo "Vous n'avez pas le droit d'accès à cette page.<br>";
		echo "<a href='../../index.php'>Revenir</a> à la page d'accueil";
	}
	?>
</div>

<?php
include("footer.php");
?>





