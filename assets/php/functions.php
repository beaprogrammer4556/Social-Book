<?php
require('config.php');


function arrange($pagename,$data=""){
    include("assets/pages/$pagename.php");
}

function formValidation($form_data){
    $response = array();
    $response['status']=true;
    if(!$form_data['password']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your password</div>";
        $response['status']=false;
        $response['feild']="password";
    }
    if(!$form_data['username']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your username</div>";
        $response['status']=false;
        $response['feild']="username";
    }
    if(isEmailRegistered($form_data['email'])){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Email Already registered.</div>";
        $response['status']=false;
        $response['feild']="email";
    }
    if(isUsernameRegistered($form_data['username'])){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Username Already registered.</div>";
        $response['status']=false;
        $response['feild']="username";
    }
    if(!$form_data['email']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your email</div>";
        $response['status']=false;
        $response['feild']="firstname";
    }
    if(!$form_data['lastname']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your lastname</div>";
        $response['status']=false;
        $response['feild']="lastname";
    }
    if(!$form_data['firstname']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your firstname</div>";
        $response['status']=false;
        $response['feild']="firstname";
    }
    return $response;
}

function showerror($feild){
if(isset($_SESSION['error'])){
$response = $_SESSION['error'];
if(isset($response['feild']) && $feild==$response['feild']){
    return $response['msg'];
}}
}

function showData($feild){
    if(isset($_SESSION['formdata'])){
        $formdata = $_SESSION['formdata'];
        return $formdata[$feild];
    }
}

function isEmailRegistered($email){
    global $con;
    $stmt =$con->prepare("select * from users where email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $res= $stmt->get_result();
    return $res->num_rows;
}
function isUsernameRegistered($username){
    global $con;
    $stmt =$con->prepare("select * from users where username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $res= $stmt->get_result();
    return $res->num_rows;
}

function isupdateUsernameRegistered($username){
    global $con;
    $db_id = $_SESSION['user'][0]['Id'];
    $stmt =$con->prepare("select * from users where username=? && id!=?");
    $stmt->bind_param("si",$username,$db_id);
    $stmt->execute();
    $res= $stmt->get_result();
    return $res->num_rows;
}

function insert_user_details($data){
    global $con;
    $firstname = mysqli_real_escape_string($con,$data['firstname']);
    $lastname = mysqli_real_escape_string($con,$data['lastname']);
    $gender = $data['gender'];
    $email = mysqli_real_escape_string($con,$data['email']);
    $username = mysqli_real_escape_string($con,$data['username']);
    $password = mysqli_real_escape_string($con,$data['password']);
    $password = md5($password);
    $stmt=$con->prepare("insert into users(firstname,lastname,gender,email,username,password) values(?,?,?,?,?,?)");
    $stmt->bind_param('ssisss',$firstname,$lastname,$gender,$email,$username,$password);
    if($stmt->execute()){
        header('location:../../?login&newuser');
    }else{
        die($con->error);
    }
}

function loginValidation($form_data){
    $response=array();
    $response['status']=true;
    $blank=false;
    if(!$form_data['password']){
        $response['msg']="<div class='alert alert-danger my-2'>Please provide your password</div>";
        $response['status']=false;
        $response['feild']="password";
        $blank=true;
    }
    if(!$form_data['email_username']){
        $response['msg']="<div class='alert alert-danger my-2'>Please provide username or email</div>";
        $response['status']=false;
        $response['feild']="email_username";
        $blank=true;
    }
    if(!$blank && !checkUser($form_data)['status']){
        $response['msg']="<div class='alert alert-danger my-2'>Invalid email/username or password</div>";
        $response['status']=false;
        $response['feild']="checkUser";
    }else{
        $response['user']=checkUser($form_data)['user'];
    }
    
    return $response;
}


function checkUser($data){
    global $con;
    $email_username = $data['email_username'];
    $pass = $data['password'];
    $password = md5($pass);
    $stmt = $con->prepare("select * from users where (email=? || username=?) && password=?");
    $stmt->bind_param("sss",$email_username,$email_username,$password);
    $stmt->execute();
    $res = $stmt->get_result();
    $result['user']=$res->fetch_all(MYSQLI_ASSOC)??array();
    if(count($result['user'])>0){
      $result['status']=true;
    }else{
        $result['status']=false;
    }
    return $result;
}
function getUser($userId){
    global $con;
    $stmt = $con->prepare("select * from users where Id=?");
    $stmt->bind_param("i",$userId);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}

function filterFollowSuggestions(){
    global $con;
    $list = allUsers();
    $filter_list = array();

    foreach ($list as $listuser){
     if(!checkFollowStatus($listuser['Id'])){
        $filter_list[]=$listuser;
     }
    }
    return $filter_list;
}

function checkFollowStatus($user_id){
    global $con;
    $current_user_id = $_SESSION['user'][0]['Id'];
    $stmt = $con->prepare("select count(*) from followers where follower_id=? && user_id=?");
    $stmt->bind_param("ii",$current_user_id,$user_id);
    $stmt->execute();
    return $stmt->get_result();
}

function allUsers(){
    global $con;
    $user_id = $_SESSION['user'][0]['Id'];
    $stmt = $con->prepare("select * from users where Id!=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}
function getPost(){
    global $con;
    $stmt = $con->prepare("select p.id,p.user_id,p.post_img,p.post_text,p.created_at,u.firstname,u.lastname,u.username,u.profile_pic from posts as p join users as u where u.Id=p.user_id order by p.post_img desc");
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}

function getUserByUsername($username){
    global $con;
    $stmt = $con->prepare("select * from users where username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}

function getPostById($userId){
    global $con;
    $stmt = $con->prepare("select * from posts where user_id=? order by id desc");
    $stmt->bind_param("i",$userId);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}


function verifyEmail($email){
    global $con;
    $stmt = $con->prepare("update users set ac_status=1 where email=?");
    $stmt->bind_param("s",$email);
    return $stmt->execute();
}

function changePassword($email,$password){
    global $con;
    $newPassword = md5($password);
    $stmt = $con->prepare("update users set password=? where email=?");
    $stmt->bind_param("ss",$newPassword,$email);
    return $stmt->execute();
}

function updateFormValidation($form_data,$image_data){
    $response = array();
    $response['status']=true;
    if(!$form_data['username']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your username</div>";
        $response['status']=false;
        $response['feild']="username";
    }
    if(!$form_data['lastname']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your lastname</div>";
        $response['status']=false;
        $response['feild']="lastname";
    }
    if(!$form_data['firstname']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your firstname</div>";
        $response['status']=false;
        $response['feild']="firstname";
    }
    if(isupdateUsernameRegistered($form_data['username'])){
        $response['msg'] = "<div class='alert alert-danger my-2' role='alert'>" . htmlspecialchars($form_data['username']) . " is Already registered.</div>";
        $response['status']=false;
        $response['feild']="username";
    }

    if($image_data['name']){
       $img = basename($image_data['name']);
       $type = strtolower(pathinfo($img,PATHINFO_EXTENSION));
       $size = $image_data['size']/1000;

       if($type!='jpg' && $type!='jpeg' && $type!='png'){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>only jpg,jpeg,png images are allowed</div>";
        $response['status']=false;
        $response['feild']='profile_pic';
       }
       if($size>1000){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>upload image less than 1 mb</div>";
        $response['status']=false;
        $response['feild']='profile_pic';
       }
    }
    return $response;
}

function postValidation($form_data,$image_data){
    $response = array();
    $response['status']=true;

    if(!$image_data['name']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>please provide an image.</div>";
        $response['status']=false;
        $response['feild']="post_img";
    }

    if($image_data['name']){
       $img = basename($image_data['name']);
       $type = strtolower(pathinfo($img,PATHINFO_EXTENSION));
       $size = $image_data['size']/1000;

       if($type!='jpg' && $type!='jpeg' && $type!='png'){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>only jpg,jpeg,png images are allowed</div>";
        $response['status']=false;
        $response['feild']='post_img';
       }
       if($size>1000){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>upload image less than 1 mb</div>";
        $response['status']=false;
        $response['feild']='post_img';
       }
    }
    return $response;
}


function updateProfile($form_data,$image_data){
     global $con;
     $firstname = mysqli_real_escape_string($con,$form_data['firstname']);
     $lastname = mysqli_real_escape_string($con,$form_data['lastname']);
     $username = mysqli_real_escape_string($con,$form_data['username']);
     
     if($form_data['password']){
      $password = $form_data['password'];
      $password = md5($password);
      $_SESSION['user'][0]['password']=$password;
     }else{
      $password = $_SESSION['user'][0]['password'];
     }
     
    //  $profile_pic="";
     if($image_data['name']){
        $img_name = time().basename($image_data['name']);
        $img_dir = "../img/profile/$img_name";
        move_uploaded_file($image_data['tmp_name'],$img_dir);
        $profile_pic = $img_name;
        $_SESSION['user'][0]['profile_pic']=$profile_pic;
     }else{
        $profile_pic = $_SESSION['user'][0]['profile_pic'];
     }

     $stmt = $con->prepare("update users set firstname=?,lastname=?,username=?,password=?,profile_pic=? where email=?");
     $stmt->bind_param('ssssss',$firstname,$lastname,$username,$password,$profile_pic,$_SESSION['user'][0]['email']);
     return $stmt->execute();
}

function createPost($form_data,$image_data){
    global $con;
    $user_id = $_SESSION['user'][0]['Id'];
    $post_text = mysqli_real_escape_string($con,$form_data['post_text']);
   
       $img_name = time().basename($image_data['name']);
       $img_dir = "../img/posts/$img_name";
       move_uploaded_file($image_data['tmp_name'],$img_dir);
       $post_img = $img_name;
       $_SESSION['user'][0]['post_img']=$post_img;
    

    $stmt = $con->prepare("insert into posts(user_id,post_img,post_text) values(?,?,?)");
    $stmt->bind_param('iss',$user_id,$post_img,$post_text);
    return $stmt->execute();
}
?>  