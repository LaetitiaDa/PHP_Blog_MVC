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

<br />
    <h1>Login</h1>
    <br />

    <form method="post">
        <span>Email :</span><input type="text" name="email"><br>
        <span>Password :</span><input type="password" name="password"><br>
        <button type="submit" name="submit" value="Submit">Submit</button>
    </form>
    <p> If you do not have an account yet, you can register <a href='registration_user'>here</a></p>


<footer class="green accent-2">
<div class="basPage">
<h5 font class="police">CONTACT :</h5> 
<h6>Bibliothèque Platypuce - 13 rue de la Pleiade - FRANCE</h6>
</div>
</footer>

</body>
</html>