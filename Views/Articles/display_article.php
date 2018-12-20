<!DOCTYPE <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>display_article</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../../../Webroot/Css/materialize.min.css" media="screen,projection"/>
        <link href="../../../Webroot/Css/style.css" rel="stylesheet">
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

    <h2><?php echo $articles['title'];?> </h2>
    
    <p><?php echo $articles['content'];?></p>
    <p>Published on: <?php echo $articles['creation_date'];?></p>
    <p>Last modification :<?php echo $articles['modification_date'];?></p></p>
    <p>Article written by : <?php echo $articles['username'];?></p>

    <?php if($_SESSION['session_groups']!='user'){?>
    <a href="../delete_article/?id=<?php echo $articles['id'];?>">Delete </a> <br>
    <a href="../edit_article/?id=<?php echo $articles['id'];?>">Edit </a> <br /><br>

    <p><a href="../../Comments/create_comment/?id=<?php echo $articles['id'];?>">Create Comment</a></p>


    <table>
    <caption>Comments :</caption>
    <tr>
        <th>Author</th>
        <th>Comment</th>
        <th>Date</th>
        <th>Modify</th>
        <th>Delete</th>
    </tr>
    <?php
    foreach($comments as $comment)
    {?>
        <tr>
            <td><?php echo $comment['username'];?></td>
            <td><?php echo $comment['content'];?></td>
            <td><?php echo $comment['creation_date'];?></td>
            <td><a href="../../Comments/edit_comment/?id=<?php echo $comment['id'];?>">Modify</a></td>
            <td><a href="../../Comments/delete_comment/?id=<?php echo $comment['id'];?>">Delete</a></td>
        </tr>
    <?php }?>
    </table><br>

<p> Come back to list of articles <a href='../display_articles'>here</a></p>

    </body>

    <?php   
    }}?>

    <footer class="green accent-2">
<div class="basPage">
<h5 font class="police">CONTACT :</h5> 
<h6>Bibliothèque Platypuce - 13 rue de la Pleiade - FRANCE</h6>
</div>
</footer>
</html>