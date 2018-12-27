<?php
session_start();
$page_title = "Suppression produit"; 
include("header.php");

?>
<div id="container">
	<?php
	if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {

		if (!isset($_GET["rid"])) { 
			echo "<p class='alert'>Erreur</p>";

		}else if (!isset($_POST["supprimer"]) && !isset($_POST["annuler"]) ){ 
			include("del_form.php");

		} else if (isset($_POST["annuler"])){ 
			echo "<p class='alert'>Operation annulée.</p>";

		} else {


			$rid = $_GET["rid"];

			try {
				
				require(__DIR__ ."/../../db_config.php");

				$SQL = "DELETE FROM recettes WHERE rid = ? "; 
				$st = $db->prepare($SQL);
				$res = $st->execute([$rid]);

		if (!$res) {
			echo "<p class='alert'>Erreur de suppression.<p>";
		}
		else echo "<p class='alert'>La suppression a été effectuée.</p>";

		$db=null;
	}
	catch (PDOException $e) {
		echo "Erreur SQL: ".$e->getMessage(); 
	}
}
?>
<a href="liste.php">Liste </a>produits
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