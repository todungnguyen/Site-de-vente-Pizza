<?php
session_start();

$page_title = 'Liste';
include("header.php");

?>

<div id="container">

	<?php
	if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {
		?>
		<h1>Liste des commandes: </h1>

		<?php

		try {

			require(__DIR__ ."/../../db_config.php");

			if(isset($_GET['ref'])) {
				$ref = $_GET['ref'];
				$SQL = "SELECT * FROM commandes WHERE ref = ?";
				$st = $db->prepare($SQL);
				$st->execute(array($ref));
				$res = $st->fetchAll(PDO::FETCH_ASSOC);

			} else if(isset($_GET['statut'])) {
				$statut = $_GET['statut'];
				$SQL = "SELECT * FROM commandes WHERE statut = ?";
				$st = $db->prepare($SQL);
				$st->execute(array($statut));
				$res = $st->fetchAll(PDO::FETCH_ASSOC);

			} else if(isset($_GET['date'])) {
				$date = $_GET['date'];
				$SQL = "SELECT * FROM commandes WHERE date = ?";
				$st = $db->prepare($SQL);
				$st->execute(array($date));
				$res = $st->fetchAll(PDO::FETCH_ASSOC);
			} 


			else {
				$SQL = "SELECT * FROM commandes";
				$res = $db->query($SQL);
			}
			?>

			<table>
				<tr>
					<th>cid</th>
					<th>ref</th>
					<th>uid</th>
					<th>rid</th>
					<th>date</th>
					<th>prix total</th>
					<th>statut</th>
				</tr>

				<?php
				foreach($res as $row) {
					?>

					<tr>
						<td><?php echo $row['cid'] ?></td>
						<td><a href="liste.php?ref=<?php echo $row['ref'] ?>"><?php echo $row['ref'] ?></a></td>
						<td><?php echo $row['uid'] ?></td>
						<td><?php echo $row['rid'] ?></td>
						<td><a href="liste.php?date=<?php echo $row['date'] ?>"><?php echo $row['date'] ?></a></td>

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

						<td><a href="liste.php?statut=<?php echo $row['statut'] ?>"><?php echo $row['statut']?></a></td>
					</tr>

					<?php } ?>
				</table>
				<br>
				<a href='liste.php'>Liste</a> des commandes
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

