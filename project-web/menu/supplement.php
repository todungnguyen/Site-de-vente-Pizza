<?php
session_start();

$title = "Supplement";
include("header.php");

///////////////////////////////////////////////////////////////////////////

if(isset($_GET['rid'])) {

	if(!isset($_SESSION['rpt'])) {
		$_SESSION['rpt'] = 0;
	} else {
		$_SESSION['rpt']++;
	}

	$rid = intval($_GET['rid']);

	try {

		require("../db_config.php");

		$SQL = "SELECT COUNT(*) FROM recettes WHERE rid = $rid";
		$st = $db->prepare($SQL);
		$st->execute();

		$number = $st->fetchColumn();

		if($number != 0) {
			$SQL = "SELECT * FROM recettes WHERE rid = $rid";
			$st = $db->prepare($SQL);
			$st->execute();

			$result = $st->fetchAll(PDO::FETCH_ASSOC);

			foreach ($result as $row) { 
				$_SESSION['recette'][$_SESSION['rpt']]=array(
					"rid" => $row['rid'],
					"prix" => $row['prix']
				);
			}

		} else {

			echo "Produit invalide!!!<br>";
		}

		$db = null; 
	}

	catch (PDOException $e){
		echo "Erreur SQL: ".$e->getMessage(); 
	}
}

///////////////////////////////////////////////////////////////////////////

if(isset($_GET['sid'])) {

	$sid=intval($_GET['sid']);

	if(isset($_GET['ajout_rpt'])) {
		$rpt = $_GET['ajout_rpt'];
	} else {
		$rpt = $_SESSION['rpt'];
	}
	
	try {

		require("../db_config.php");

		$SQL = "SELECT COUNT(*) FROM supplements WHERE sid = $sid";
		$st = $db->prepare($SQL);
		$st->execute();

		$number = $st->fetchColumn();


		if($number != 0) {
			$SQL = "SELECT * FROM supplements WHERE sid = $sid";
			$st = $db->prepare($SQL);
			$st->execute();

			$result = $st->fetchAll(PDO::FETCH_ASSOC);

			foreach ($result as $row) { 
				$_SESSION['supplement'][$rpt][$sid] = $row['prix'];
			}

		} else {
			echo "Produit invalid!!!<br>";
		}

		$db = null; 
	}

	catch (PDOException $e){
		echo "Erreur SQL: ".$e->getMessage(); 
	}

}
?>

<div id="container">
	
	<div id="main">

		<h1> Liste des suppléments: </h1>

		<table>
			<tr>
				<th>sid</th>
				<th>Nom</th>
				<th>Prix</th>
				<th>Action</th>
			</tr>

			<?php

			try {

				require("../db_config.php");

				$SQL = "SELECT * FROM supplements";
				$res = $db->query($SQL);

				foreach ($res as $row) {

					?>

					<tr>
						<td><?php echo $row['sid'] ?></td>
						<td><?php echo $row['nom'] ?></td>
						<td><?php echo $row['prix'] ?></td>

						<?php
						if(isset($_GET['ajout_rpt'])) {
							$rpt = $_GET['ajout_rpt'];
							?>
							<td><a href="supplement.php?sid=<?php echo $row['sid'] ?>&ajout_rpt=<?php echo $rpt ?>">Ajouter au panier</a></td>

							<?php } else if(isset($_SESSION['recette'])){ ?>

							<td><a href="supplement.php?sid=<?php echo $row['sid'] ?>">Ajouter au panier</a></td>

							<?php } else { ?>
							<td><a href="supplement.php">Ajouter au panier</a></td>
							<?php } ?>

						</tr>

						<?php

					}

					?>

				</table>

				<?php

				$db = null; 
			}

			catch (PDOException $e) {
				echo "Erreur SQL: ".$e->getMessage(); 
			}
			?>
			<br>
			<a href="produit.php">Ajouter</a> un pizza
			<br><br>
			<a href='../index.php'>Revenir</a> à la page d'accueil
		</div>


		<div id="sidebar">
			<h1>Panier</h1>

			<?php
			if(isset($_SESSION['recette']) || isset($_SESSION['supplement'])) {	

				require("../db_config.php");

				if(isset($_SESSION['recette'])) {

					$rpt = 0;
					$rid = 0;
					while($rpt <= $_SESSION['rpt']) {
						if(isset($_SESSION['recette'][$rpt])) {
							foreach($_SESSION['recette'][$rpt] as $id => $value) { 
								if($id == 'rid') {
									$rid = $value;
								}
							}

							$SQL = "SELECT * FROM recettes WHERE rid = $rid";
							$res = $db->query($SQL);

							foreach($res as $row) {
								echo $row['nom']."<br>";
							}

							if(isset($_SESSION['supplement'][$rpt])) {

								$SQL = "SELECT * FROM supplements WHERE sid IN(";

								foreach($_SESSION['supplement'][$rpt] as $sid => $value) {
									$SQL.=$sid.",";
								}

								$SQL = substr($SQL,0,-1).")";

								$res = $db->query($SQL);

								foreach($res as $row) {
									echo "+  ".$row['nom']."<br>";
								}
							}
							echo "<br>";
						}
						$rpt++;
					}
				} 

			} else {
				echo "<p>Votre panier est vide. Veillez ajouter des produits.</p>";
			}
			?>

			<hr>

			<a href="panier.php">Panier</a>



		</div>

	</div>

	<?php
	include "footer.php";
	?>

