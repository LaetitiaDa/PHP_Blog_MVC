<?php

include_once("AppController.php");

class UsersController extends AppController
{  
    function __construct()
    {
        $this->table = "Users";
        session_start();
    }

    public function display_users()
    {
        if($_SESSION['session_groups']!='admin' || $_SESSION['session_status']!='not blocked')
        {
            echo "you do not have the rights to see this page. Please contact you administrator";
        }
        else
        {
            $obj = $this->loadModel("Users"); // crée objet de la class Model Users
            $users = $obj->find_all("users"); // cherche data de la db dans model
            foreach($users as $key => $user)
            {
                $users[$key]['id']=htmlspecialchars($user['id']);
                $users[$key]['username']=htmlspecialchars($user['username']);
                $users[$key]['email']=htmlspecialchars($user['email']);
                $users[$key]['groups']=htmlspecialchars($user['groups']);
                $users[$key]['status']=htmlspecialchars($user['status']);
            }
            require($this->render('display_users.php')); // appel la view 
        }
    } 

    public function delete_user() // delete a user
    {
        if($_SESSION['session_groups']!='admin' || $_SESSION['session_status']!='not blocked')
        {
            echo "you do not have the rights to see this page. Please contact you administrator";
        }
        else
        {
            $obj = $this->loadModel("Users");
            $this->display_users();

            if(isset($_GET["delete"]))
            {
                $id = $this->secure_input($_GET["delete"]);
                $id = $_GET["delete"]; 
                $obj->delete($id, 'users');
            }
            else
            {
                return "No user to delete selected";
            }
            header('Location: /PHP_Rush_MVC/Controllers/Users/display_users');
        }
    }

    public function select_user($id) //allows to search all info for 1 user searching by id
    {
        if($id!=null)
        {
            $obj = $this->loadModel("Users"); 
            $users = $obj->find_one($id, 'users');

            if($users[0]['id']==null)
            {
                return "id doesn't exist";
            }
            else
            {
                foreach($users as $key => $user)
                {
                    $users[$key]['id']=htmlspecialchars($user['id']);
                    $users[$key]['username']=htmlspecialchars($user['username']);
                    $users[$key]['email']=htmlspecialchars($user['email']);
                    $users[$key]['groups']=htmlspecialchars($user['groups']);
                    $users[$key]['status']=htmlspecialchars($user['status']);
                }
                return $users;
            }
        }
        else
        {
            return "No parameter id";
        }
    }


    public function registration_user()
    {
        $reg_exp= " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";

        $obj = $this->loadModel("Users"); //New user
        
        if($_POST['username']!= null && $_POST['password']!= null && $_POST['password_c']!= null && $_POST['email']!= null) //if everything is filled
        {
            //all conditions ok to create a new user
            if(strlen($_POST['username']) >= 3 && strlen($_POST['username']) <= 10
            && $_POST['password'] == $_POST['password_c'] && strlen($_POST['password']) >= 8 && strlen($_POST['password']) <= 20
            && preg_match($reg_exp, $_POST['email'])==true)
            {
                $hashpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $users = $obj->create($_POST['username'], $hashpassword, $_POST['email'], "user", "not blocked");
                header('Location: /PHP_Rush_MVC/Controllers/Users/login');
            }
            if(strlen($_POST['username']) < 3 || strlen($_POST['username']) > 10) //wrong username
            {
                echo "Invalid username";
            }
            if($_POST['password'] != $_POST['password_c'] || strlen($_POST['password']) < 8 || strlen($_POST['password']) > 20) //wrong password
            {
                echo "Invalid password";
            }
            if(preg_match($reg_exp, $_POST['email'])==false) //wrong email
            {
                echo "Invalid email";
            }
        }
        else
        {
            echo "all fields must be filled";
        }
        require($this->render('registration_user.php')); // appel la view
    }

    public function login()
    {
        $obj = $this->loadModel("Users");
        $reg_exp= " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";

        if($_POST['email']== null && $_POST['password']== null){}
        else if(preg_match($reg_exp, $_POST['email'])==false 
        || strlen($_POST['password']) < 8 || strlen($_POST['password']) > 20)
        {
            echo "invalid email/password";
        }
        else
        {
            $users = $obj->log_in($_POST['email']);

            if(password_verify($_POST['password'], $users['password'])==true)
            {
                session_start();
                $_SESSION["session_status"]=$users['status'];
                $_SESSION["session_groups"]=$users['groups'];
                $_SESSION["session_id"]=$users['id'];
                $_SESSION["session_name"]=$users['username'];
                echo "you are logged in";
                header('Location: ../Articles/display_articles');
            }
            else
            {
                echo "invalid email/password";
            }
        }
        require($this->render('login.php')); // appel la view
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ../Users/login');
    }

    public function user_delete()
    {
        if($_SESSION['session_groups']!='admin' || $_SESSION['session_status']!='not blocked')
        {
            echo "you do not have the rights to see this page. Please contact you administrator";
        }
        else
        {
            session_start();
            if($_SESSION["session_id"] != null)
            {
                $obj = $this->loadModel("Users");
                $id = $_SESSION["session_id"];
                $obj->delete($id, 'users');
            }
            else
            {
                echo "error no user to delete";
            }
        }
    }

    public function manage_account()
    {
        if(($_POST['account_delete'])!=null)
        {
            $this->user_delete();
        }
        require($this->render('manage_account.php')); // appel la view

    }

    public function secure_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function create_user()
    {
        if($_SESSION['session_groups']!='admin' || $_SESSION['session_status']!='not blocked')
        {
            echo "you do not have the rights to see this page. Please contact you administrator";
        }
        else
        {
        $reg_exp= " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";

        $obj = $this->loadModel("Users"); //New user
        
        if($_POST['username']!= null && $_POST['password']!= null 
        && $_POST['password_c']!= null && $_POST['email']!= null && $_POST['groups']!= null) //if everything is filled
        {
            //all conditions ok to create a new user
            if(strlen($_POST['username']) >= 3 && strlen($_POST['username']) <= 10
            && $_POST['password'] == $_POST['password_c'] && strlen($_POST['password']) >= 8 && strlen($_POST['password']) <= 20
            && preg_match($reg_exp, $_POST['email'])==true)
            {
                $hashpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $users = $obj->create($_POST['username'], $hashpassword, $_POST['email'], $_POST['groups'], "not blocked");
                echo "user created";
            }
            if(strlen($_POST['username']) < 3 || strlen($_POST['username']) > 10) //wrong username
            {
                echo "Invalid username";
            }
            if($_POST['password'] != $_POST['password_c'] || strlen($_POST['password']) < 8 || strlen($_POST['password']) > 20) //wrong password
            {
                echo "Invalid password";
            }
            if(preg_match($reg_exp, $_POST['email'])==false) //wrong email
            {
                echo "Invalid email";
            }
        }
        else
        {
            echo "all fields must be filled";
        }
        require($this->render('create_user.php')); // appel la view
    }
    }


    public function edit_user()
    {
        if($_SESSION['session_groups']!='admin' || $_SESSION['session_status']!='not blocked')
        {
            echo "you do not have the rights to see this page. Please contact you administrator";
        }
        else
        {
        if(isset($_GET["modify"]))
        {
            $reg_exp= " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";

            $obj = $this->loadModel("Users"); //New user
        
            if($_POST['username']!= null && strlen($_POST['username']) >= 3 && strlen($_POST['username']) <= 10)
            {
                $users = $obj->edit($_GET["modify"], $_POST['username'], "", "", "", "");
                echo "username modified";
            }
            else if ($_POST['username']!= null && (strlen($_POST['username']) < 3 || strlen($_POST['username']) > 10))
            {
                echo "invalid username. Couldn't update this argument";
            }
            if($_POST['password']!= null && $_POST['password_c']!= null 
            && $_POST['password'] == $_POST['password_c'] && strlen($_POST['password']) >= 8 
            && strlen($_POST['password']) <= 20)
            {
                $hashpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $users = $obj->edit($_GET["modify"], "", $hashpassword, "", "", "");
                echo "password modified";
            }
            else if($_POST['password']!= null && $_POST['password_c']!= null 
            && ($_POST['password'] != $_POST['password_c'] || strlen($_POST['password']) < 8 
            || strlen($_POST['password']) > 20))
            {
                echo "invalid password. Couldn't update this argument";
            }
            if($_POST['email']!= null && preg_match($reg_exp, $_POST['email'])==true)
            {
                $users = $obj->edit($_GET["modify"], "", "", $_POST['email'], "", "");
                echo "email modified";
            }
            else if($_POST['email']!= null && preg_match($reg_exp, $_POST['email'])!=true)
            {
                echo "invalidemail. Couldn't update this argument";
            }
            if($_POST['groups'] != null)
            {
                $users = $obj->edit($_GET["modify"], "", "", "", $_POST['groups'], "");
                echo "groups modified";
            }
            if($_POST['status'] != null)
            {
                $users = $obj->edit($_GET["modify"], "", "", "", "", $_POST['status']);
                echo "status modified";
            }
            require($this->render('modify_user.php')); // appel la view
        } 
        else
            {
                echo "no user selected to modify";
            }
        }
            
    }
}
?>