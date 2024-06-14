    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
        <?php
                if (isset($_SESSION['forgot_code']) && !isset($_SESSION['temp_auth'])) {
                    $action = 'verifycode';
                }elseif (isset($_SESSION['forgot_code']) && isset($_SESSION['temp_auth'])) {
                    $action = 'changePassword';
                }else {
                    $action = 'forgotpassword';
                }
        ?>
            <form method="POST" action="assets/php/actions.php?<?=$action?>">
                <div class="d-flex justify-content-center">
                </div>
                <h1 class="h5 mb-3 fw-normal">Forgot Your Password ?</h1>

                <?php
                if($action == 'forgotpassword'){
                    ?>
                    <div class="form-floating">
                    <input type="email" name="email" class="form-control rounded-0" placeholder="username/email">
                    <label for="floatingInput">Enter Your Email</label>
                    <?php echo showerror('email');?>
                    <br>
                    <button class="btn btn-primary" type="submit">Send Verification Code</button>
                   </div>
                    <?php
                }
                ?>
                <?php
                if($action == 'verifycode'){
                    ?>
                    <p>Enter 6 Digit Code Sended to <?=$_SESSION['forgot_email'];?></p>
                   <div class="form-floating mt-1">
                    <input type="text" name="code" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">######</label>
                    <?php echo showerror('email_verify');?>
                    <br>
                    <button class="btn btn-primary" type="submit">Verify Code</button>
                   </div>    
                    <?php
                }
                ?>
                 <?php
                if($action == 'changePassword'){
                    ?>
                    <p>Enter a new password</p>
                     <div class="form-floating mt-1">
                    <input type="password" name="new_password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">new password</label>
                    <?php echo showerror('new_password');?>
                    <br>
                    <button class="btn btn-primary" type="submit">Change Password</button>
                    </div>
                    <?php
                }
                ?>
                <!-- <div class="form-floating mt-1">
                    <input type="password" name="new_password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">new password</label>
                </div>
                <p>Enter 6 Digit Code Sended to You</p>
                <div class="form-floating mt-1">

                    <input type="text" name="otp" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">######</label>
                </div> -->
                <!-- <div class="mt-3 d-flex justify-content-between align-items-center"> -->
                    <!-- <button class="btn btn-primary" type="submit">Send Verification Code</button> -->
                    <!-- <button class="btn btn-primary" type="submit">Change Password</button>
                    <button class="btn btn-primary" type="submit">Verify Code</button> -->

                <!-- </div> -->
                <br>
                <a href="?login" class="text-decoration-none mt-5"><i class="bi bi-arrow-left-circle-fill"></i> Go Back
                    To
                    Login</a>
            </form>
        </div>
    </div>
