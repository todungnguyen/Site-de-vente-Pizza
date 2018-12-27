<?php
session_start();

$page_title = "Facture";

include("header.php");


?>

<link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body>
	<div id="facture">
		<?php
		if(isset($_GET['ref']) && isset($_GET['cid'])) {
			$ref = $_GET['ref'];
			$cid =  $_GET['cid'];
			?>
			<h3>Commande le numéro: <?php echo $ref ?></h3>

			<table>
				<tr>
					<th>Nom</th>
					<th>Quantite</th>
					<th>Prix</th>
				</tr>

				<?php
				$i = 0;
				try {
					
					require("../db_config.php");

					$SQL = "SELECT * FROM commandes WHERE ref = ? AND cid = ?";
					$st = $db->prepare($SQL);
					$st->execute(array($ref,$cid));

					$res = $st->fetchAll(PDO::FETCH_ASSOC);

					foreach($res as $row) {
						$rid = $row['rid'];
						$cid = $row['cid'];
					}

					$SQL1 = "SELECT * FROM recettes WHERE rid = $rid";
					$res1 = $db->query($SQL1);

					foreach($res1 as $row1) {
						?>
						<tr>
							<td><?php echo $row1['nom']; ?></td>
							<td style="text-align: center"><?php echo 1; ?></td>
							<td><?php echo $row1['prix']; ?></td>
						</tr>

						<?php
					}

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
							?>
							<tr>
								<td><?php echo $row3['nom']; ?></td>
								<td style="text-align: center"><?php echo 1; ?></td>
								<td><?php echo $row3['prix']; ?></td>
							</tr>

							<?php
						}
					}

					$db = null; 
				}

				catch (PDOException $e) {
					echo "Erreur SQL: ".$e->getMessage(); 
				}
			} else {
				echo "ERREUR.<br>";
			}
			?>
		</table>
		<br>
		<a href='espace_client.php'>Revenir</a> à l'espace client
		<br><br>
		<a href='../index.php'>Revenir</a> à la page d'accueil
	</div>
	<?php
	include "footer.php";
	?>