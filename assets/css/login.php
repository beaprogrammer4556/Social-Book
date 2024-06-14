<form method="POST" action="assets/php/actions.php?login" >
<div class="rows">
<div class="container">
<div class="text">
        <p>Please Sign In</p>
    </div>

    <div class="rows">
    <input type="text" id ="email_username" placeholder="Username or email" name="email_username" value="<?php echo showData('email_username');?>" class="inputfeild">
    </div>
    <?php echo showerror('email_username');?>

    <div class="rows">
    <input type="password" id ="password" placeholder="Password" name="password" value="<?php echo showData('password');?>" class="inputfeild">
    </div>
    <?php echo showerror('password');?>
    <input type="hidden" name="checkUser"  class="inputfeild">

    <?php echo showerror('checkUser');?>
    <button type="submit" name="submit" class="btn btn-primary">Log In</button>
    </div>
</div>
  </form>
