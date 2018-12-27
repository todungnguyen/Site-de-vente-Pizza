<?php
session_start();
$page_title = 'Liste';
include("header.php");

?>

<div id="container">

	<?php
	if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {
		?>

		<h1>Liste des produits: </h1>

		<?php

		try {
			
			require(__DIR__ ."/../../db_config.php");

			$SQL = "SELECT * FROM recettes";
			$res = $db->query($SQL);
			?>

			<table>
				<tr>
					<th>ID</th>
					<th>nom</th>
					<th>prix</th>
					<th>action</th>
				</tr>

				<?php
				foreach($res as $row) {
					?>

					<tr>
						<td><?php echo $row['rid'] ?></td>
						<td><?php echo $row['nom'] ?></td>
						<td><?php echo $row['prix'] ?></td>
						<td><a href="del.php?rid=<?php echo $row['rid']?>">Delete</a> / <a href="mod.php?rid=<?php echo $row['rid']?>">Modifier</td>
						</tr>

						<?php } ?>
					</table>
					<br>
					<a href = "ajout.php">Ajouter</a>
					<br><br>
					<a href='../controle.php'>Revenir</a> à la page administrateur
					<br><br>
					<a href='../../index.php'>Revenir</a> à la page d'accueil

					<?php

					$db = null; 
				}

				catch (PDOException $e) {
					echo "Erreur SQL: ".$e->getMessage(); 
				}

			} else {
				echo "Vous n'avez pas le droit d'accès à cette page.<br>";
				echo "<a href='../../index.php'>Revenir</a> à la page d'accueil";
			}
			?>
		</div>

		<?php
		include "footer.php";
		?>

