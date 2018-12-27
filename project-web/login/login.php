<?php
ob_start();
session_start();
$page_title = "Login";
include("header.php");
?>

<link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body>
	
	<?php

	if(!isset($_POST["login"])) {
		echo "<p class='alert'>Account incomplet.</p>";
		require("login_form.php");
	}

	else if(!isset($_POST["pass"])) {
		echo "<p class='alert'>Password incomplet.</p>";
		require("login_form.php");
	}

	else {
		$log = $_POST["login"];

		$pass = $_POST["pass"];

		$pass = md5($pass);


		try {

			require("../db_config.php");

			$SQL = "SELECT COUNT(*) FROM users WHERE login = ? AND mdp = ?";
			$st = $db->prepare($SQL);
			$res = $st->execute(array($log,$pass));

			if(!$res) {
				echo "<p class='alert'>Error to connect</p>";

			} else {

				$number = $st->fetchColumn();

				if ($number != 0) {

					$SQL = "SELECT * FROM users WHERE login = ? AND mdp = ?";
					$st = $db->prepare($SQL);
					$st->execute(array($log,$pass));

					$result = $st->fetchAll(PDO::FETCH_ASSOC);

					foreach ($result as $row) {
						$_SESSION['uid'] = $row['uid'];
						$_SESSION['login'] = $row['login'];
						$_SESSION['nom'] = $row['nom'];
						$_SESSION['prenom'] = $row['prenom'];
						$_SESSION['role'] = $row['role'];
					}
					?>



					<div id="container"> 
						<?php
						echo "Bonjour, votre compte est ".$_SESSION['login'].", votre role est: ".$_SESSION['role']."<br>";

						if($row['role'] == 'admin') {
							?>
							<a href="../admin/controle.php">Administrateur</a> &emsp; &emsp; &emsp; <a href="../index.php">Home</a>
							<?php
						} 
						else {
							header("Location:../index.php");
							exit();
						} 
						?>
					</div>

					<?php }

					else {
						echo "<p class='alert'>Compte n'existe pas ou mot de passe incorrect.</p>";
						require("login_form.php");
					}
				}
				$db = null; 
			}

			catch (PDOException $e){
				echo "Erreur SQL: ".$e->getMessage(); 
			}
		}

		include("footer.php");
		?>

