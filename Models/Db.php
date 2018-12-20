<?php


class Model
{
    protected $pdo;
    protected $table;

    public function __construct()
    {
        if (is_null($this->pdo))
        {
            $this->pdo = $this->connect_db('localhost','root','root',3306,'PHP_Rush_MVC');
        }
    }

    private function connect_db($host, $username, $password, $port, $db)
    {
        try
        {
            $pdo = new PDO('mysql:dbname='.$db.';host=' .$host.';port='.$port, $username, $password);
            return $pdo;
        }
        catch (PDOException $pdoException)
        {
            $message = "Error connection to DB\n";
        }
    }

    public function find_all($table)
    {
        $sql = 'select * from '.$table.';';
        $data = $this->pdo->query($sql);
        $result = $data->fetchAll();
        if(!empty($result))
        {
            return $result;
        }
    }

    public function find_one($id,$table)
    {
        $sql = 'select * from '.$table.' where id ='.$id.';';
        $data = $this->pdo->query($sql);
        $result = $data->fetchAll();
        if(!empty($result))
        {
            return $result;
        }
    }

    public function delete($id,$table)
    {
        $sql = 'DELETE FROM '.$table.' WHERE id ='.$id.';';
        $this->pdo->exec($sql);
    }

}



?>