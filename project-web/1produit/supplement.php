<?php
session_start();

$title = "Supplement";
include("header.php");


///////////////////////////////////////////////////////////////////////////

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
				//set session variables
				$_SESSION['recette']=array(
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


/////////////////////////////////////////////////////////////////////////


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
				$_SESSION['supplement'][$sid]=$row['prix'];
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
						<td><a href="supplement.php?sid=<?php echo $row['sid'] ?>">Ajouter au panier</a></td>
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
		<a href='../index.php'>Revenir</a> à la page d'accueil
	</div>


	<div id="sidebar">
		<h1>Panier</h1>
		<?php
		if(isset($_SESSION['recette']) || isset($_SESSION['supplement'])) {	

			$prixtotal = 0;

			$db = new PDO("mysql:host=$host;dbname=$db", $login, $mdp);

			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			if(isset($_SESSION['recette'])) {
				$rid = 0;
				foreach($_SESSION['recette'] as $id => $value) { 
					if($id == 'rid') {
						$rid = $value;
					}
				}

				require("../db_config.php");

				$SQL = "SELECT * FROM recettes WHERE rid = $rid";
				$res = $db->query($SQL);

				foreach($res as $row) {
					echo $row['nom']." x 1<br>";
				}
			}

			if(isset($_SESSION['supplement'])) {

				require("../db_config.php");

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

		}else {
			echo "<p>Votre panier est vide. Veillez ajouter des produits.</p>";
		}

		?>
	</table>

	<hr>

	<a href="panier.php">Panier</a>


</div>

</div>

<?php
include "footer.php";
?>





