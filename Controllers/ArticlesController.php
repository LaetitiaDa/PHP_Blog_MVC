<?php

include_once("AppController.php");

class ArticlesController extends AppController
{  
    function __construct()
    {
        $this->table = "Articles";
        session_start();
    }
  
    public function display_articles()// ATTENTION, il faudra ajouter une condition session active pour accéder à la page
    {
        if(isset($_SESSION['session_id']))
        { 
            $obj = $this->loadModel("Articles");

            if(!isset($_POST['search']))
            {            
                $articles = $obj->find_all();
            }
            if(isset($_POST['search']))
            {
                $articles = $obj->search_all($_POST['search']);
            }
            foreach($articles as $key => $article)
            {
                $articles[$key]['title']=htmlspecialchars($article['title']);
                $articles[$key]['content']=htmlspecialchars($article['content']);
                $articles[$key]['creation_date']=htmlspecialchars($article['creation_date']);
                $articles[$key]['modification_date']=htmlspecialchars($article['modification_date']);
                $articles[$key]['username']=htmlspecialchars($article['username']);
                $articles[$key]['id']=htmlspecialchars($article['id']);
            }
            require($this->render('display_articles.php')); // appelle la view 
        }
        else
        {
            header('Location: ../Users/login');
        }
    }


    public function select_article()  // ATTENTION, il faudra ajouter une condition session active pour accéder à la page
    {
        if($_SESSION['session_id'] != null)
        {       
            $id = $this->secure_input($_GET['id']);

            if(isset($id))
            {
                $obj = $this->loadModel("Articles"); 
                $obj2 = $this->loadModel("Comments");
                $articles = $obj->find_one($id, 'articles');
                $comments = $obj2->display_comments($id);

                if($articles[0]['id']==null)
                {
                    return "requested article doesn't corresponds to any existing one";
                }
                else
                {
                    foreach($articles as $key => $article)
                    {
                        $articles[$key]['id']=htmlspecialchars($article['id']);
                        $articles[$key]['title']=htmlspecialchars($article['title']);
                        $articles[$key]['content']=htmlspecialchars($article['content']);
                        $articles[$key]['creation_date']=htmlspecialchars($article['creation_date']);
                        $articles[$key]['modification_date']=htmlspecialchars($article['modification_date']);
                        $articles[$key]['username']=htmlspecialchars($article['status']);
                    }
                    foreach($comments as $key => $comment)
                    {
                        $comments[$key]['id']=htmlspecialchars($comment['id']);
                        $comments[$key]['username']=htmlspecialchars($comment['username']);
                        $comments[$key]['content']=htmlspecialchars($comment['content']);
                        $comments[$key]['creation_date']=htmlspecialchars($comment['creation_date']);
                    }

                    require($this->render('display_article.php')); // appelle la view 
                }
            }
            else
            {
                echo "you need to log in first";
                return;
            }
        } 
    }
    

    public function create_article()//n'ai pas pu test avec des posts mais la création d'article marche en dur 
    {
        if($_SESSION['session_groups'] == "writer"|| $_SESSION['session_groups'] == "admin")
        {
            $obj = $this->loadModel("Articles");

            if($_POST['title'] != null && $_POST['content'] != null)
            {
                $obj->create($_POST['title'], $_POST['content'], $_SESSION['session_id']);
            }
            require($this->render('create_article.php')); 
        }

        else 
        {
            echo "you are not allowed to publish a new article";
            return;
        }
    }


    public function delete_article()
    {
        if($_SESSION['session_groups'] == "writer"|| $_SESSION['session_groups'] == "admin")// il faut que le client soit admin ou writer
        {
            $id=$this->secure_input($_GET["id"]);

            if($_SESSION['session_groups'] == "admin" && $id != null)// s'il est admin, il efface tous les articles qu'il veut. 
            {
                $obj = $this->loadModel("Articles");
                $obj->delete($id, 'articles');
            }

            else if($_SESSION['session_groups'] == "writer" && $id  != null)// s'il est writer, on vérifie que l'article à effacer est bien celui qu'il a écrit
            {
                $obj = $this->loadModel("Articles");
                $articles = $obj->find_one($id, 'articles');// on récupère l'article à delete
                if($articles[0]['id']==null)
                {
                    echo "requested article doesn't corresponds to any existing one";
                }
                else
                {
                    foreach($articles as $key => $article)// on traite l'array récupéré
                    {
                        $articles[$key]['creator_id']=htmlspecialchars($article['id']);
                    }

                    if($articles['creator_id'] == $_SESSION['session_id'])// on vérifie que l'id du creator est bien celui de la session active
                    {
                        $obj->delete($id, 'articles');
                    }
                    else
                    {
                        echo "you can't delete this article";
                    }
                } 
            }
            else
            {
                echo "error no article to delete";
            }
            header('Location: /PHP_Rush_MVC/Controllers/Articles/display_articles');
        }
        else
        {
            echo "you do not have the rights to delete this article";
        }
    }

    public function edit_article()
    {
        if($_SESSION['session_groups'] == "writer"|| $_SESSION['session_groups'] == "admin")// il faut que le client soit admin ou writer
        {
            $obj = $this->loadModel("Articles");// on vérifie en 1er que l'id de l'articl existe vraiment dans la db
            $articles = $obj->find_one($_GET["id"], 'articles');
            if($articles['id']==null)
            {
                return "requested article doesn't corresponds to any existing one";
            }
            else
            {
                if($_SESSION['session_groups'] == "admin")// s'il est admin, il édite tous les articles qu'il veut. 
                {
                    require($this->render('edit_article.php'));
                    if($_POST['content']!= null &&  $_POST['title']!= null)
                    {
                        $obj->edit($_GET["id"],$_POST['title'], $_POST['content'],$_SESSION['id']);// la modif
                    }
                }

                else if($_SESSION['session_groups'] == "writer")// s'il est writer, on vérifie que l'article à edit est bien celui qu'il a écrit
                {
                    foreach($articles as $key => $article)// on traite l'array récupéré
                    {
                        $articles[$key]['creator_id']=htmlspecialchars($article['id']);
                    }

                    if($articles['creator_id'] == $_SESSION['session_id'])// on vérifie que l'id du creator est bien celui de la session active
                    {
                        require($this->render('edit_article.php'));
                        if($_POST['content']!= null ||  $_POST['title']!= null)
                        {
                            $obj->edit($_GET["id"],$_POST['title'], $_POST['content']);// la modif
                        }
                    }

                    else 
                    {
                        echo "you have no rights to modify this article.";
                        return;
                    }
                }
            }
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

?>