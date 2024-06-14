    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form method="POST" action="assets/php/actions.php?signup">
                <div class="d-flex justify-content-center">
                    <img class="mb-4" src="img/pictogram.png" alt="" height="45">
                </div>
                <h1 class="h5 mb-3 fw-normal">Create new account</h1>
                <div class="d-flex">
                    <div class="form-floating mt-1 col-6 ">
                        <input type="text" class="form-control rounded-0" name="firstname" placeholder="username/email" value="<?php echo showData('firstname');?>" >
                        <label for="floatingInput">first name</label>
                    </div>
                    <div class="form-floating mt-1 col-6">
                        <input type="text" class="form-control rounded-0" name="lastname"  placeholder="username/email" value="<?php echo showData('lastname');?>">
                        <label for="floatingInput">last name</label>
                    </div>
                </div>
                <?php echo showerror('firstname');?>
                <?php echo showerror('lastname');?>
                <div class="d-flex gap-3 my-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio"  name="gender"  id="exampleRadios1"
                            value="1" <?=showData('gender')==1?"checked":""?>>
                        <label class="form-check-label" for="exampleRadios1">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"  name="gender"  id="exampleRadios3"
                            value="2" <?=showData('gender')==2?"checked":""?>>
                        <label class="form-check-label" for="exampleRadios3">
                            Female
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"  name="gender"  id="exampleRadios2"
                            value="0" <?=showData('gender')==0?"checked":""?>>
                        <label class="form-check-label" for="exampleRadios2">
                            Other
                        </label>
                    </div>
                </div>
                <div class="form-floating mt-1">
                    <input type="email" class="form-control rounded-0" name="email" placeholder="username/email" value="<?php echo showData('email');?>">
                    <label for="floatingInput">email</label>
                </div>
                <?php echo showerror('email')?>
                <div class="form-floating mt-1">
                    <input type="text" class="form-control rounded-0" name="username" value="<?php echo showData('username');?>" placeholder="username/email">
                    <label for="floatingInput">username</label>
                </div>
                <?php echo showerror('username')?>
                <div class="form-floating mt-1">
                    <input type="password" class="form-control rounded-0" id="floatingPassword" name="password" placeholder="Password">
                    <label for="floatingPassword">password</label>
                </div>
                <?php echo showerror('password')?>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit" name="submit">Sign Up</button>
                    <a href="?login" class="text-decoration-none">Already have an account ?</a>
                </div>

            </form>
        </div>
    </div>
