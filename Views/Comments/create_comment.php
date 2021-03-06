<!DOCTYPE <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>comment creation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../../../Webroot/Css/materialize.min.css" media="screen,projection"/>
        <link href="../../../Webroot/Css/style.css" rel="stylesheet">
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

    <h2>Add a new Comment to this article</h2>

    <form method="post">
    <label> Content of the comment : </label> <input type="textarea"  name="content"> <br>
    <input type="submit" value = "Submit" name="SubmitButton">
    </form><br>

    <p> Come back to list of articles <a href='../../Articles/display_articles'>here</a></p>

<footer class="green accent-2">
<div class="basPage">
<h5 font class="police">CONTACT :</h5> 
<h6>Bibliothèque Platypuce - 13 rue de la Pleiade - FRANCE</h6>
</div>
</footer>

    </body>
</html>