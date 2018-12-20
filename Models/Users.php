<?php

include('Db.php');

class Users extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function log_in($email)// log in general pour admin ou user
    {
        $sql = 'SELECT * FROM users WHERE email=:email;';
        $req = $this->pdo->prepare($sql);
        $req->execute(array(':email' => $email));
        $result = $req->fetch();
        if (!empty($result))
        {
            return $result;
        }
        return NULL;
        
    }

    public function create($username, $password, $email, $groups, $status)//il 'agit du create côté admin 
    {
        $sql = 'INSERT INTO users (username, password, email, groups, status, creation_date, modification_date) 
        values ("'.$username.'","'.$password.'","'.$email.'","'.$groups.'","'.$status.'", CURDATE(), CURDATE());';
        $this->pdo->exec($sql);
    }


    public function edit($id, $username=null, $password=null, $email=null, $groups=null, $status=null)//il 'agit du edit côté admin 
    {
        if($username!= null)
        {
            $sql = 'UPDATE users SET username = "'.$username.'", modification_date =CURDATE() WHERE id ='.$id.';'; 
            $this->pdo->exec($sql);
        }

        if($password!= null)
        {
            $sql = 'UPDATE users SET password = "'.$password.'", modification_date =CURDATE() WHERE id ='.$id.';';  
            $this->pdo->exec($sql);
        }

        if($email!= null)
        {
            $sql = 'UPDATE users SET email = "'.$email.'", modification_date =CURDATE() WHERE id ='.$id.';'; 
            $this->pdo->exec($sql);
        }
     
        if($groups!= null)
        {
            $sql = 'UPDATE users SET groups = "'.$groups.'", modification_date =CURDATE() WHERE id ='.$id.';'; 
            $this->pdo->exec($sql);
        }

        if($status!= null)
        {
            $sql = 'UPDATE users SET status = "'.$status.'", modification_date =CURDATE() WHERE id ='.$id.';'; 
            $this->pdo->exec($sql);
        }

    }
}

?>