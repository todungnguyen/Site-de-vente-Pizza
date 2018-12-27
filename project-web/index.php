<?php
session_start();

$title = "Home's Pizza";
include("header.php");
?>

<header>
	<h1> Home's Pizza </h1>
	<p> Pizza fait maison. </p>

	<?php 
	if (isset($_SESSION['prenom']) && isset($_SESSION['nom'])) {
		echo '<p style="text-align: right;">Bonjour '.$_SESSION['nom']." ".$_SESSION['prenom']."</p>";
		echo '<p style="text-align: right;"><a href="login/logout.php">Déconnecter</a></p>';
	}
	else {
		echo 'Appuiez login pour enregister \/';
	}
	?>

</header>

<nav>
	<?php

	if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {
		?>
		<a href="admin/controle.php" class="left">Admin</a>
		<a href="menu/produit.php" class="left">Menu</a>
		<?php
	} else {
		?>
		<a href="menu/produit.php" class="left">Menu</a>
		<?php } ?>

		<a href="menu/panier.php" >Panier</a>
		<?php
		if(!isset($_SESSION['login'])) {
			?>
			<a href="login/login_form.php">Login</a>
			<?php
		} else {
			?>
			<a href="login/espace_client.php">Espace Client</a>
			<?php } ?>

		</nav>

		<img src = "pizza.jpg" alt = "pizza" />

		<footer>
			<div class = "right" style = "text-align:center">
				<h3 style ="font-size: 24px"> Service Client</h3> 
				<p> 0705-543-137 </p>
				<p> onlinepizza@gmail.com</p>
			</div>
			<div class = "left">
				<p><b>Adresse:</b> XX rue XXXXX - 75010 Paris</p>
				<p><b>Horaire:</b> 9am - 10pm </p>
			</div>
		</footer>


		<?php
		include "footer.php";
		?>




















