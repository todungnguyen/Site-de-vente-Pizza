<?php
$page_title = "Register";

include("header.php");
?>

<link rel="stylesheet" type="text/css" href="style.css" />

</head>

<body>
    <div id="container1">
        <h2>Register</h2>
        <form action = "add_account.php" method="POST">
            <table>
                <tr>
                    <td> Nom: </td>
                    <td> <input type="text" name="nom" required></td>
                </tr>
                <tr>
                    <td> Prenom: </td>
                    <td> <input type="text" name="prenom" required></td>
                </tr>
                <tr>
                    <td> Account: </td>
                    <td> <input type="text" name="login" required></td>
                </tr>
                <tr>
                    <td> Password: </td>
                    <td> <input type="password" name="pass" required></td>
                </tr>
            </table>
            <input type="submit" value="Register">
        </form>

        <br>
        <a href='../index.php'>Revenir</a> à la page d'accueil
    </div>
    
    <?php
    include("footer.php");
    ?>

