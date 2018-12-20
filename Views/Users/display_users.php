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
if($_SESSION['session_groups']!='admin' || $_SESSION['session_status']!='not blocked')
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

<a href='create_user'>Create a new user</a>
<table>
    <caption>List of Users</caption>
    <tr>
        <th>id</th>
        <th>Username</th>
        <th>Email</th>
        <th>Groups</th>
        <th>Status</th>
        <th>Modify</th>
        <th>Delete</th>
    </tr>
    <?php
    foreach($users as $user)
    {?>
        <tr>
            <td><?php echo $user['id'];?></td>
            <td><?php echo $user['username'];?></td>
            <td><?php echo $user['email'];?></td>
            <td><?php echo $user['groups'];?></td>
            <td><?php echo $user['status'];?></td>
            <td><a href="edit_user/?modify=<?php echo $user['id'];?>">Modify</a></td>
            <td><a href="delete_user/?delete=<?php echo $user['id'];?>">Delete</a></td>
        </tr>
    <?php }?>
</table>

<footer class="green accent-2">
<div class="basPage">
<h5 font class="police">CONTACT :</h5> 
<h6>Bibliothèque Platypuce - 13 rue de la Pleiade - FRANCE</h6>
</div>
</footer>

</body>

<?php } ?>
</html>