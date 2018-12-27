<?php
$page_title = "Add account";

include("header.php");

?>

<link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body>
	<?php

	if(!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['login']) || !isset($_POST['pass']) || empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['login']) || empty($_POST['pass'])) {
		echo "<p class='alert'>Information invalide.</p>";
		include("register_form.php");
	}

	else {
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$log = $_POST['login'];
		$pass = $_POST['pass'];

		$pass = md5($pass);

		try {

			require("../db_config.php");

			$SQL = "SELECT COUNT(*) FROM users WHERE login = ?";
			$st = $db->prepare($SQL);
			$st->execute(array($log));

			$number = $st->fetchColumn();

			if($number != 0) {
				echo "<p class='alert'>Compte ".$log." est déjà existant.</p>";
				include("register_form.php");
			} 

			else {

				$SQL = "INSERT INTO users (nom,prenom,login,mdp) VALUES (?,?,?,?)";
				$st = $db->prepare($SQL);
				$res = $st->execute(array($nom,$prenom,$log,$pass));

				if (!$res) {
					echo "<p class='alert'>Error</p>";
				} else {
					?>

					<div id="container">
						<?php
						echo "Bonjour ".$prenom." ".$nom.". Bienvenue dans notre magasin.<br>";
						echo "Veillez appuiez "; 
						?>
						<a href="login.php">ici</a>
						<?php
						echo " pour vérifier votre compte la première fois.<br>";
						?>
					</div>
					<?php
				}

				$db = null; 
			}
		}

		catch (PDOException $e){
			echo "Erreur SQL: ".$e->getMessage(); 
		}
	}

	include("footer.php");
	?>
