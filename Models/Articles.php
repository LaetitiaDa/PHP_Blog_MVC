<?php

include_once("/home/laetitia/Rendu/PHP_Rush_MVC/Models/Db.php");

class Articles extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function find_all()
    {
        $sql = 'select title, articles.id, content, articles.creation_date, articles.modification_date, users.username from articles INNER JOIN 
        users ON users.id = articles.creator_id order by articles.modification_date desc;';
        $data = $this->pdo->query($sql);
        $result = $data->fetchAll();
        if(!empty($result))
        {
            return $result;
        }
    }

    public function search_all($param)
    {
        $sql = "select title, articles.id, content, articles.creation_date, articles.modification_date, users.username from articles INNER JOIN 
        users ON users.id = articles.creator_id  WHERE articles.title LIKE '%".$param."%' order by articles.modification_date desc;";
        $data = $this->pdo->query($sql);
        $result = $data->fetchAll();
        if(!empty($result))
        {
            return $result;
        }
    }

    public function find_one($id,$table)
    {
        $sql = 'select title, articles.id, content, articles.creation_date, articles.creator_id, articles.modification_date, users.username from '.$table.' INNER JOIN 
        users ON users.id = articles.creator_id where articles.id ='.$id.' order by modification_date desc;';
        $data = $this->pdo->query($sql);
        $result = $data->fetch();
        if(!empty($result))
        {
            return $result;
        }
    }

    public function create($title, $content, $creator_id)
    {
        $sql = 'INSERT INTO articles (title, content, creator_id, creation_date, modification_date) 
        values ("'.$title.'","'.$content.'","'.$creator_id.'", CURDATE(), CURDATE());';
        $this->pdo->exec($sql);
        return "article added";
    }

    

    public function edit($id, $title = null, $content = null)//il 'agit du edit côté admin 
    {
        if($title != null)
        {
            $sql = 'UPDATE articles SET title = "'.$title.'", modification_date =CURDATE()
            WHERE id ="'.$id.'";';           
            $this->pdo->exec($sql);
        }

        if($content != null)
        {
            $sql = 'UPDATE articles SET content = "'.$content.'", modification_date =CURDATE()
            WHERE id ="'.$id.'";';           
            $this->pdo->exec($sql);
        }
    }
}


?>