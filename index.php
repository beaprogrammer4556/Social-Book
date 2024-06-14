<?php 
include("assets/php/functions.php");

$pagecount = count($_GET);

if(isset($_GET['newfp'])){
    unset($_SESSION['temp_auth']);
    unset($_SESSION['forgot_email']);
    unset($_SESSION['forgot_code']);
}
if(isset($_SESSION['auth'])){
    $user = getUser($_SESSION['user'][0]['Id']);
    $posts = getPost();
    $allUser = filterFollowSuggestions();
}
if(isset($_SESSION['auth']) && $user[0]['ac_status'] == 0 && !$pagecount){
    arrange('header',['title'=>'Verification']);
    arrange('verify_email');
}elseif(isset($_SESSION['auth']) && $user[0]['ac_status'] == 1 && !$pagecount){    
    arrange('header',['title'=>'Social Book']);
    arrange('navbar');
    arrange('wall');
}elseif(isset($_SESSION['auth']) && $user[0]['ac_status'] == 2 && !$pagecount){    
    arrange('header',['title'=>'blocked']);
    arrange('blocked');
}elseif(isset($_SESSION['auth']) && isset($_GET['editprofile']) && $user[0]['ac_status'] == 1){    
    arrange('header',['title'=>'edit_profile']);
    arrange('navbar');
    arrange('edit_profile');
}elseif(isset($_SESSION['auth']) && isset($_GET['u']) && $user[0]['ac_status'] == 1){    
    $profile = getUserByUsername($_GET['u']);
    if(!$profile){
        arrange('header',['title'=>'edit_profile']);
        arrange('navbar');
        arrange('profile_not_found');
    }else{
    $posted_img = getPostById($profile[0]['Id']);
    arrange('header',['title'=>$profile[0]['firstname'].' '.$profile[0]['lastname']]);
    arrange('navbar');
    arrange('profile');
    }
}elseif(isset($_GET['signup'])){
arrange('header',['title'=>'SignUp']);
arrange('signup');
}elseif(isset($_GET['login'])){
    arrange('header',['title'=>'Login']); 
    arrange('login'); 
}elseif(isset($_GET['forgot_password'])){
    arrange('header',['title'=>'Forgot Password']); 
    arrange('forgot_password'); 
}else{
    if(isset($_SESSION['auth']) && $user[0]['ac_status'] == 1){
        arrange('header',['title'=>'Social Book']);
        arrange('navbar');
        arrange('wall');
    }elseif(isset($_SESSION['auth']) && $user[0]['ac_status'] == 2 ){    
            arrange('header',['title'=>'blocked']);
            arrange('blocked');
        }elseif(isset($_SESSION['auth']) && $user[0]['ac_status'] == 0 ){    
            arrange('header',['title'=>'Verification']);
    arrange('verify_email');
        }else{
        arrange('header',['title'=>'Login']); 
        arrange('login');
    } 
}
arrange('footer');
unset($_SESSION['error']);
unset($_SESSION['formdata']);
?>