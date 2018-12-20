<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="../../Webroot/Css/materialize.min.css" media="screen,projection"/>
    <link href="../../Webroot/Css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body class="container">

<?php
session_start();
if($_SESSION['session_status']!='not blocked')
{
    echo "you do not have the rights to see this page. Please contact you administrator";
}
else
{
?>

     <nav>
        <div class="nav-wrapper green accent-2">
        <a href="/PHP_Rush_MVC/Controllers/Articles/display_articles" class="brand-logo center"><img src="../../Webroot/Css/books.png" title="home" alt="home"></a>
        <ul id="nav-mobile" class="right">
        <li><a href="/PHP_Rush_MVC/Controllers/Users/display_users"><i class="small material-icons">supervisor_account</i></a></li>
        <li><a href="/PHP_Rush_MVC/Controllers/Users/manage_account"><i class="small material-icons">account_circle</i></a></li>
        <li><a href="/PHP_Rush_MVC/Controllers/Users/logout"><i class="small material-icons">directions_run</i></a></li>
        </ul>
        </div>
    </nav>
    <h1>Manage your account</h1>
    <br />
    <form method="post">
        <input name="account_delete" type="submit" value="Delete account">
    </form>

    <footer class="green accent-2">
        <div class="basPage">
        <h5 font class="police">CONTACT :</h5> 
        <h6>Bibliothèque Platypuce - 13 rue de la Pleiade - FRANCE</h6>
        </div>
    </footer>

</body>

<?php } ?>
</html>




