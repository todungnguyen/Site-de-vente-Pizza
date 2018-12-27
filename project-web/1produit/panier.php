<?php
session_start();

$title = "Cart";
include "header.php";

if(isset($_GET['supprimer'])) {

	if($_GET['supprimer'] == 'recette') {

		unset($_SESSION['recette']); 

	}
	else {

		if(isset($_GET['idsup'])) {

			$idsup = $_GET['idsup'];

			unset($_SESSION['supplement'][$idsup]);

			if(empty($_SESSION['supplement'])) {

				unset($_SESSION['supplement']);
				echo "unset supplement.<br>";

			}
		}
		else {

			echo "Error id.<br>";

		}
	}
}



if(isset($_GET['rid'])) {

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

				$_SESSION['recette']=array(
					"rid" => $row['rid'],
					"price" => $row['prix']
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


if(isset($_GET['sid'])) {

	$sid=intval($_GET['sid']);

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

					//set session variables
				$_SESSION['supplement']=array(
					"sid" => $row['sid'],
					"price" => $row['prix']
				);
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

<!-- sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss --> 

<div id="container">

	<div id="main">

		<h1>View Cart</h1>
		<?php 
		if(isset($_SESSION['recette']) || isset($_SESSION['supplement'])) {	
			?>
			<table>
				<tr>
					<th>Nom</th>
					<th>Quantite</th>
					<th>Prix</th>
					<th>Action</th>
				</tr>

				<?php
				$prixtotal = 0;

				require("../db_config.php");

				if(isset($_SESSION['recette'])) {
					$rid = 0;
					foreach($_SESSION['recette'] as $id => $value) { 
						if($id == 'rid') {
							$rid = $value;
						}
					}

					$SQL = "SELECT * FROM recettes WHERE rid = $rid";
					$res = $db->query($SQL);

					foreach($res as $row) {
						$prixtotal = $prixtotal + $row['prix'];
						?>

						<tr> 
							<td><?php echo $row['nom'] ?></td> 
							<td>1</td>
							<td><?php echo $row['prix'] ?>€</td>
							<td><a href="panier.php?supprimer=recette">Supprimer</a></td>
						</tr>

						<?php
					}
				} 

				if(isset($_SESSION['supplement'])) {

					$SQL = "SELECT * FROM supplements WHERE sid IN(";

					foreach($_SESSION['supplement'] as $sid => $value) {
						$SQL.=$sid.",";
					}

					$SQL = substr($SQL,0,-1).")";

					$res = $db->query($SQL);

					foreach($res as $row) {
						$prixtotal = $prixtotal + $row['prix'];
						?>

						<tr> 
							<td><?php echo $row['nom'] ?></td> 
							<td>1</td>
							<td><?php echo $row['prix'] ?>€</td>
							<td><a href="panier.php?supprimer=supplement&idsup=<?php echo $row['sid'] ?>">Supprimer</a></td>
						</tr>

						<?php
					}

					?>

					<tr> 
						<td colspan="4">Prix total: <?php echo $prixtotal ?>€</td> 
					</tr> 

					<?php
				} 

			} else {
				echo "<p>Votre panier est vide. Veillez ajouter des produits.</p>";
			}

			?>
		</table>

		<?php
		if(!isset($_SESSION['recette'])) {
			?>
			<br>
			<a href="produit.php">Ajouter</a> un pizza
			<br>

			<?php
		}

		?>
		<br>
		<a href="supplement.php">Ajouter</a> un supplement
		<br><br>
		<a href='../index.php'>Revenir</a> à la page d'accueil
	</div>

	<!-- sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss --> 

	<div id="sidebar">
		<h1>Cart</h1>
		<?php
		if(isset($_SESSION['recette']) || isset($_SESSION['supplement'])) {	

			$prixtotal = 0;

			if(isset($_SESSION['recette'])) {

				$SQL = "SELECT * FROM recettes WHERE rid = $rid";
				$res = $db->query($SQL);

				foreach($res as $row) {
					echo $row['nom']." x 1<br>";
				}
			}

			if(isset($_SESSION['supplement'])) {

				$SQL = "SELECT * FROM supplements WHERE sid IN(";

				foreach($_SESSION['supplement'] as $sid => $value) {
					$SQL.=$sid.",";
				}

				$SQL = substr($SQL,0,-1).")";

				$res = $db->query($SQL);

				foreach($res as $row) {
					echo $row['nom']." x 1<br>";
				}
			} 

		} else {
			echo "<p>Votre panier est vide. Veillez ajouter des produits.</p>";
		}

		?>
	</table>

	<hr>

	<?php
	if(isset($_SESSION['recette'])) {
		?>
		<a href="add_commande.php">Payment</a>
		<?php
	}
	else {
		echo "Il faut au moin un pizza dans votre panier.<br>";
		?>
		<a href="panier.php">Payment</a>
		<?php
	}
	?>


</div>

</div>

<?php
include "footer.php";
?>
