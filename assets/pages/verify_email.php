  <?php
 global $user;

?>
    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form method="POST" action="assets/php/actions.php?verifyotp">
                <div class="d-flex justify-content-center">


                </div>
                <h1 class="h5 mb-3 fw-normal">Verify Your Email Id <?php echo $user[0]['email'];?></h1>
                <p>Enter 6 Digit Code Sended to You</p>
                <div class="form-floating mt-1">

                    <input type="password" class="form-control rounded-0" name="userotp" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">######</label>
                </div>
                <?php
                if(isset($_GET['statusshow'])){
                    echo $_SESSION['otpstatus'];
                }
                ?>
                <?php
                if(isset($_GET['resended'])){
                    ?>
                    <p class="text-success">code resend successfully</p>
                    <?php
                }
                ?>
                <?php echo showerror('email_verify')?>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit" >Verify Email</button>
                    <a href="assets/php/actions.php?resend_code" class="text-decoration-none" type="text">Resend Code</a>
                </div>
                <br>
                <a href="assets/php/actions.php?logout" class="text-decoration-none mt-5"><i class="bi bi-arrow-left-circle-fill"></i>
                    Logout</a>
            </form>
        </div>
    </div>


