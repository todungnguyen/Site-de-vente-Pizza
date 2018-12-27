<?php
session_start();
?>

<link rel="stylesheet" href="controle.css" />

<body>

	<div id="container">

		<?php
		if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {
			?>
			<h1> Page controle: </h1>

			<ul>
				<li><a href="pizza/liste.php" >Pizza</a></li>	
				<li><a href="supplement/liste.php" >Supplements</a></li>
				<li><a href="commande/liste.php">Commande</a></li>
			</ul>
			<br>
			<?php } else { 
				echo "Vous n'avez pas le droit d'accès à cette page.<br>";
			}
			?>

			<a href='../index.php'>Revenir</a> à la page d'accueil
		</div>

	</body>