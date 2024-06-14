<?php

require_once("functions.php");
require_once("send_code.php");

if(isset($_GET['signup'])){
    $response = formValidation($_POST);
    if($response['status']){
        insert_user_details($_POST);
    }else{
        $_SESSION['error']=$response;
        $_SESSION['formdata']=$_POST;
        header('location:../../?signup');
    }
}

if(isset($_GET['login'])){
    $response = loginValidation($_POST);
    if($response['status']){
      $_SESSION['auth']=true;
      $_SESSION['user']=$response['user'];
      if($response['user'][0]['ac_status']==0){
        $_SESSION['otp']=$otp = rand(111111,999999);
        sendcode($response['user'][0]['email'],'email verification',$otp);
      }
      header('location:../../');
    }else{
        $_SESSION['error']=$response;
        $_SESSION['formdata']=$_POST;
        header('location:../../?login');
    }
}
if(isset($_GET['resend_code'])){
    $_SESSION['otp']=$otp = rand(111111,999999);
     sendcode($_SESSION['user'][0]['email'],'Verify Your Email',$otp);
        header('location:../../?resended');
}
    
if(isset($_GET['verifyotp'])){
    $originalotp = $_SESSION['otp'];
    $userotp = $_POST['userotp'];
    if($originalotp==$userotp){
        if(verifyEmail($_SESSION['user'][0]['email'])){
            header("location:../../");
        }else{
            echo "something is wrong";
        }
        
    }else{
         $response['msg']="<div class='alert alert-danger my-2'>Incorrect otp !</div>";
        $response['feild']="email_verify";
        $_SESSION['error']=$response;
        header("location:../../");
    }
}

if(isset($_GET['forgotpassword'])){
   if(!$_POST['email']){
    $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please enter your email.</div>";
    $response['feild']="email";
    $_SESSION['error'] = $response;
    header('location:../../?forgot_password');
   }elseif(!isEmailRegistered($_POST['email'])){
    $response['msg']="<div class='alert alert-danger my-2' role='alert'>Email not registered.</div>";
    $response['feild']="email";
    $_SESSION['error'] = $response;
    header('location:../../?forgot_password');
  }else{
     $_SESSION['forgot_email'] = $_POST['email'];
     $_SESSION['forgot_code']=$otp = rand(111111,999999);
     sendcode($_POST['email'],'Forgot Your Password?',$otp);
     header('location:../../?forgot_password&resended');
  }
}

if(isset($_GET['verifycode'])){
    $originalotp = $_SESSION['forgot_code'];
    $userotp = $_POST['code'];
    if($originalotp==$userotp){
        $_SESSION['temp_auth']=true;
        header("location:../../?forgot_password");
        }else{
         $response['msg']="<div class='alert alert-danger my-2'>Incorrect otp !</div>";
         if(!$_POST['code']){
            $response['msg']="<div class='alert alert-danger my-2'>please enter 6 digit otp</div>";
         }
        $response['feild']="email_verify";
        $_SESSION['error']=$response;
        header("location:../../?forgot_password");
    }
}

if(isset($_GET['changePassword'])){
    if(!$_POST['new_password']){
        $response['msg']="<div class='alert alert-danger my-2' role='alert'>Please provide your password</div>";
        $response['feild']="new_password";
        $_SESSION['error']=$response;
        header("location:../../?forgot_password");
    }else{
        changePassword($_SESSION['forgot_email'],$_POST['new_password']);
        header("location:../../?reseted");
    }
}

if(isset($_GET['updateprofile'])){

    $response = updateFormValidation($_POST,$_FILES['profile_pic']);
    if($response['status']){
        updateProfile($_POST,$_FILES['profile_pic']);
        header('location:../../?editprofile&success');
    }else{
        $_SESSION['error']=$response;    
        header('location:../../?editprofile');
    }
}

if(isset($_GET['addpost'])){
    $response = postValidation($_POST,$_FILES['post_img']);
    if($response['status']){
        if(createPost($_POST,$_FILES['post_img'])){
        header('location:../../?new_post_added');
        }else{
            echo "something went wrong";
        }
    }else{
        $_SESSION['error']=$response;    
        header('location:../../');
    }
}

if(isset($_GET['logout'])){
    session_destroy();
    header("location:../../");
}
?>