<?php

include_once("AppController.php");

class CommentsController extends AppController
{  
    function __construct()
    {
        $this->table = "Comments";
        session_start();
    }

    public function create_comment()//n'ai pas pu test avec des posts mais la création d'article marche en dur 
    {
        if($_SESSION['session_id'] != null && $_GET['id'] !=null)
        {
            $commentator_id = $this->secure_input($_SESSION['session_id']);
            $article_id = $this->secure_input($_GET['id']);
            $obj = $this->loadModel("Comments");

            if($_POST['content'] != null)
            {
                $obj->create_comment($commentator_id,$_POST['content'],$article_id);
                echo "new comment added";
            }
            require($this->render('create_comment.php')); 
        }

        else 
        {
            echo "Register first/ Article unidentified";
        }
    }


    public function delete_comment()
    {
        if($_SESSION['session_id'] != null && $_GET["id"]!= null)// il faut que le client soit logué et que delete ait un GET[id] existant
        {
            $comment_id=$this->secure_input($_GET["id"]);

            if($_SESSION['session_groups'] == "admin" && $comment_id != null)// s'il est admin, il efface tous les comments qu'il veut. 
            {
                $obj = $this->loadModel("Comments");
                $obj->delete($comment_id, 'comments');
                header('Location: /PHP_Rush_MVC/Controllers/Articles/display_articles');
            }

            else if($_SESSION['session_groups'] == "writer"|| $_SESSION['session_groups'] == "users" && $comment_id != null)// on vérifie que le comment que le client veut effacer est bien celui qu'il a écrit
            {
                $obj = $this->loadModel("Comments");
                $comments = $obj->find_one($comment_id, 'comments');// on récupère le comment à delete
                
                if($comments['id']==null)// on vérifie que le commentaire choisi existe 
                {
                    return "requested comment doesn't corresponds to any existing one";
                }
                else if($comments['commentator_id'] == $_SESSION['session_id'])
                {
                    $obj->delete($comment_id, 'comments');
                    header('Location: /PHP_Rush_MVC/Controllers/Articles/display_articles');
                }
            }
            else
            {
                echo "error, no comment to delete";
            }
        }

        else
        {
            echo "you have to log in first/ undefined page";
        }
    }


    public function edit_comment()
    {
        if($_SESSION['session_groups'] != null)// être loggué
        {
            if($_GET["id"]!= null)
            {
                $comment_id = $this->secure_input($_GET["id"]);
                $obj = $this->loadModel("Comments");// on vérifie en 1er que l'id du comment existe vraiment dans la db
                $comments = $obj->find_one($comment_id, 'comments');
                
                if($comments[0]['id']==null)
                {
                    return "requested comment doesn't corresponds to any existing one";
                }

                else
                {
                    if($_SESSION['session_groups'] == "admin")// s'il est admin, il édite tous les comments qu'il veut. 
                    {
                        require($this->render('edit_comment.php'));
                        if($_POST['content']!= null)
                        {
                            $obj->edit_comment($comment_id, $_POST['content'],$_SESSION['session_id']);
                        }
                    }

                    else if($_SESSION['session_groups'] == "writer" || $_SESSION['session_groups'] == "user")// Autrement, on vérifie que le comment à edit est bien celui qu'il a écrit
                    {
                        if($comments['commentator_id'] == $_SESSION['session_id'])// on vérifie que l'id du creator est bien celui de la session active
                        {
                            require($this->render('edit_comment.php'));
                            if($_POST['content']!= null)
                            {
                                $obj->edit_comment($comment_id, $_POST['content'],$_SESSION['session_id']);
                            }
                        }
                    }
                    else 
                    {
                        echo "you have no rights to modify this article.";
                        return;
                    }
                }
            }

            else
            {
                echo "no comment # given in parameter";
            }
        }
        else
        {
            echo "log in first poto!";
        }
    }


    public function secure_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

