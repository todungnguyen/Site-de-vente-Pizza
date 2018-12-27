<?php
session_start();

$title = "Product";
include("header.php");
?>

<div id="container">

	<div id="main">
		<h1> Liste des produits: </h1>

		<table>
			<tr>
				<th>rid</th>
				<th>Nom</th>
				<th>Prix</th>
				<th>Action</th>
			</tr>

			<?php

			try {

				require("../db_config.php");

				$SQL = "SELECT * FROM recettes";
				$res = $db->query($SQL);

				foreach ($res as $row) {
					?>
					<tr>
						<td><?php echo $row['rid'] ?></td>
						<td><?php echo $row['nom'] ?></td>
						<td><?php echo $row['prix'] ?></td>

						<?php
						if(isset($_SESSION['recette'])) {
							?>
							<td><a href="supplement.php">Ajouter au panier</a></td> <?php

						} else {
							?>

							<td><a href="supplement.php?rid=<?php echo $row['rid'] ?>">Ajouter au panier</a></td> 
							<?php 
						} 
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
			<a href="supplement.php">Liste</a> des suppléments
			<br><br>
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

					$SQL = "SELECT * FROM supplements WHERE sid IN(";

					foreach($_SESSION['supplement'] as $sid => $value) {
						$SQL.=$sid.",";
					}

					$SQL = substr($SQL,0,-1).")";

					$res = $db->query($SQL);

					foreach($res as $row) {
						echo "+  ".$row['nom']." x 1<br>";
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











