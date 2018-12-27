<?php
$page_title = "Login";
include("header.php");
?>

<link rel="stylesheet" type="text/css" href="login_form.css" />
</head>

<body>
  <div id="main">
    <form action="login.php" method="POST">

      <div id="imgcontainer">
        <img src="avatar.png">
      </div>

      <div id="infocontainer">
        <label for="login"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="login" required>

        <br>

        <label for="pass"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="pass" required>

        <button type="submit">Login</button>

        <br>

        <a href="register_form.php">Nouveau client?</a> 

      </div>

    </form>

  </div>

  <?php 
  include "footer.php";
  ?>

