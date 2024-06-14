<form method="POST" action="assets/php/actions.php?login" >
    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form>
                <div class="d-flex justify-content-center">

                    <img class="mb-4" src="img/pictogram.png" alt="" height="45">
                </div>
                <h1 class="h5 mb-3 fw-normal">Please sign in</h1>

                <div class="form-floating">
                    <input type="text" class="form-control rounded-0" placeholder="username/email" name="email_username" value="<?php echo showData('email_username');?>" >
                    <label for="floatingInput">username/email</label>
                </div>
                <?php echo showerror('email_username');?>

                <div class="form-floating mt-1">
                    <input type="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password" name="password" value="<?php echo showData('password');?>">
                    <label for="floatingPassword">password</label>
                </div>
                <?php echo showerror('password');?>
                <?php echo showerror('checkUser');?>
                
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit" name="submit">Sign in</button>
                    <a href="?signup" class="text-decoration-none">Create New Account</a>


                </div>
                <a href="?forgot_password&newfp" class="text-decoration-none">Forgot password ?</a>
            </form>
        </div>
    </div>