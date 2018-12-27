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
						<td><a href="supplement.php?rid=<?php echo $row['rid'] ?>">Ajouter au panier</a></td> 
					</tr>
					<?php } ?>

				</table>

				<?php

				$db = null; 
			}

			catch (PDOException $e) {
				echo "Erreur SQL: ".$e->getMessage(); 
			}
			?>
			<br>
			<a href='../index.php'>Revenir</a> à la page d'accueil
		</div>



		<div id="sidebar">
			<h1>Panier</h1>

			<?php
			if(isset($_SESSION['recette']) || isset($_SESSION['supplement'])) {	

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

							require("../db_config.php");
							
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
