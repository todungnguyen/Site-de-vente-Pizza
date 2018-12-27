<?php
session_start();
$page_title = "Suppression"; 
include("header.php");

?>
<div id="container">
	<?php
	if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {
		if (!isset($_GET["sid"])) { 
			echo "<p class='alert'>Erreur</p>";

		}else if (!isset($_POST["supprimer"]) && !isset($_POST["annuler"]) ){ 
			include("del_form.php");

		} else if (isset($_POST["annuler"])){ 
			echo "<p class='alert'>Operation annulée.</p>";

		} else {


			$sid = $_GET["sid"];

			try {
				
				require(__DIR__ ."/../../db_config.php");

				$SQL = "DELETE FROM supplements WHERE sid = ? "; 
				$st = $db->prepare($SQL);
				$res = $st->execute([$sid]);

		if (!$res) {
			echo "<p class='alert'>Erreur de suppression<p>";
		}
		else echo "<p>La suppression a été effectuée</p>";

		$db=null;
	}
	catch (PDOException $e) {
		echo "Erreur SQL: ".$e->getMessage(); 
	}
}
?>
<a href="liste.php">Liste</a> des supplément
<br>
<a href='../../index.php'>Revenir</a> à la page d'accueil

<?php
} else {
	echo "Vous n'avez pas le droit d'accès à cette page.<br>";
	echo "<a href='../../index.php'>Revenir</a> à la page d'accueil";
}
?>
</div>

<?php

include("footer.php");
?>