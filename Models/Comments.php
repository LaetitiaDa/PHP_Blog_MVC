<?php

include_once("/home/pascal/Rendu/PHP_Rush_MVC/Models/Db.php");

class Comments extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_comment($commentator_id, $content,$article_id)//A tester 
    {
        $sql = 'INSERT INTO comments(commentator_id, content, article_id, creation_date, modification_date) 
        values ('.$commentator_id.',"'.$content.'",'.$article_id.', CURDATE(), CURDATE());';
        $this->pdo->exec($sql);
    }

    public function find_one($id,$table)
    {
        $sql = 'select * from '.$table.' where id ='.$id.';';
        $data = $this->pdo->query($sql);
        $result = $data->fetch();
        if(!empty($result))
        {
            return $result;
        }
    }

    public function display_comments($article_id)//comment faire un inner join sur 3 tableaux? 
    {
        $sql = "select comments.id, comments.content, comments.creation_date, articles.title, comments.article_id,
        users.username from (comments INNER JOIN users ON users.id = comments.commentator_id) 
        INNER JOIN articles ON articles.id = comments.article_id
        where articles.id =".$article_id." order by creation_date desc;";
        $data = $this->pdo->query($sql);
        $result = $data->fetchAll();
        if(!empty($result))
        {
            return $result;
        }    
    }

    public function edit_comment($id, $content, $commentator_id)
    {
        echo $commentator_id;
        $sql = 'UPDATE comments SET content = "'.$content.'", commentator_id = '.$commentator_id.'
        , modification_date =CURDATE() WHERE id ='.$id.';';       
        echo $sql; 
        $this->pdo->exec($sql);
    }
}

?>