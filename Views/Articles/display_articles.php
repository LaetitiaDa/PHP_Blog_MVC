<!DOCTYPE <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>blog</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../../Webroot/Css/materialize.min.css" media="screen,projection"/>
        <link href="../../Webroot/Css/style.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    
    <body class="container">
    <?php session_start();
    if($_SESSION['session_status']=='not blocked')
    {?>
    
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

    <h1>Welcome <?php echo $_SESSION['session_name'];?></h1>

    <h2>List of Articles : </h2>

    <form method="get" action="create_article">
    <button type="submit">Create new article</button>
    </form>

    <form method="post" action="">
    <input type="text" name="search"><br>
    <button type="submit">Search article</button>
    </form>

    <?php

    foreach($articles as $article)
    {?>
        <div>
            <h3><?php echo $article['title'];?></h3>
            <p><?php echo $article['content'];?></p>
            <p>Published on: <?php echo $article['creation_date'];?></p>
            <p>Last modification :<?php echo $article['modification_date'];?></p></p>
            <p>Article written by : <?php echo $article['username'];?></p>
            <a href="select_article/?id=<?php echo $article['id'];?>">Read more</a>

            <?php if($_SESSION['session_groups']!='user'){?>
            <a href="delete_article/?id=<?php echo $article['id'];?>">Delete </a>
            <a href="edit_article/?id=<?php echo $article['id'];?>">Edit </a> 
            <?php } ?>
        
        </div><br>
        
        
    <?php 
        
    }}
    else
    {
        echo "you are not allowed to access the blog";
    }?>

<footer class="green accent-2">
<div class="basPage">
<h5 font class="police">CONTACT :</h5> 
<h6>Bibliothèque Platypuce - 13 rue de la Pleiade - FRANCE</h6>
</div>
</footer>

    </body>
</html>