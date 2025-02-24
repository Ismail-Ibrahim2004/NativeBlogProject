<?php

abstract class User {
    // attributes - fields - properties
    // methods - functions
    public $id;
    public $name;
    public $email;
    public $phone;
    public $image;
    protected $password;
    public $created_at;
    public $updated_at;



    function __construct($id, $name, $email, $phone, $password, $image,$created_at, $updated_at){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->image = $image;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

    }
    public static function login($email, $password){
        $user = null;
        $qry = "SELECT * FROM USERS WHERE email = '$email' AND password = '$password' ";
        require_once('config.php');
        $cn = Mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt= mysqli_query($cn, $qry);
        if ($arr = mysqli_fetch_assoc($rslt)) {
            switch ($arr['role']) {
                case 'subscriber':
                    $user = new Subscriber($arr['id'], $arr['name'], $arr['email'], $arr['phone'], $arr['image'], $arr['password'], $arr['created_at'], $arr['updated_at']);
            
                    break;
                
                case 'Admin':
                    $user = new Admin($arr['id'], $arr['name'], $arr['email'], $arr['phone'], $arr['image'], $arr['password'], $arr['created_at'], $arr['updated_at']);

                    break;
            }
        }
        mysqli_close($cn);
        return $user;
    }
}


class Subscriber extends User{
    
    public $role = 'subscriber';
    public static function register($name, $email, $phone, $password){
        $qry = "INSERT INTO USERS (name, email, phone, password)
        VALUES ('$name', '$email', '$phone', '$password')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt= mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }

    public function store_post($title,$content,$imageName,$user_id){
        $qry = "INSERT INTO POSTS (title,content,image,user_id) values('$title','$content','$imageName','$user_id')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;

    }
    public function store_comment($comment,$post_id,$user_id){
        $qry = "INSERT INTO comments (comment,post_id,user_id) values('$comment','$post_id','$user_id')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;

    }

    public function my_posts($user_id){
        $qry = "SELECT * FROM POSTS WHERE  USER_ID = $user_id ORDER BY CREATED_AT DESC LIMIT 10";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    public function home_posts(){
        $qry = "SELECT * FROM POSTS join users on posts.user_id = users.id ORDER BY posts.CREATED_AT DESC";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    public function upated_profile_pic($imagepath,$user_id){
        $qry = "UPDATE USERS SET IMAGE= '$imagepath' WHERE id=$user_id";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function get_post_comment($post_id){
        $qry = "SELECT * FROM comments join users on comments.user_id = users.id WHERE POST_ID = $post_id ORDER BY  comments.CREATED_AT DESC";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }

}

class Admin extends User{

    public $role = 'Admin';


    function get_all_users(){
        $qry = "SELECT * FROM USERS ORDER BY CREATED_AT";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    function Delete_Account($user_id){
        $qry = "DELETE FROM USERS WHERE ID = $user_id";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
    
}