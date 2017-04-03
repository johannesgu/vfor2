<?php include 'includes/header.php'; ?>

<?php

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array(
                'required' => true,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'confirm_password' => array(
                'required' => true,
                'matches' => 'password'
            )
        ));

        if ($validation->passed()) {
            $user = new User();

            try {

                $user->create(array(
                    'email' => Input::get('email'),
                    'password' => Hash::password(Input::get('password')),
                    'joined' => date('Y-m-d H:i:s'),
                    'id_group' => 1
                ));

                Session::flash('home', 'You have been registered and can now log in');
                Redirect::to('index.php');

            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}

?>

<form class="form-signin" action="" method='post'>
    <h2 class="form-signin-heading">Register here <span class="glyphicon glyphicon-music"></span></h2>
    <label for="email" class="sr-only">Email address</label>
    <input type="email" pattern="(.*\w)@(.*[a-z])\.(.*[a-z])" title="'example@example.com'" id="email" name="email" class="form-control" placeholder="Email address" required autofocus value="<?php echo escape(Input::get('email')); ?>">
    <!-- <label for="username" class="sr-only">Username</label> -->
    <!-- <input type="text" id="username" pattern="(?=.*\w).{6,}" title="Must have alphanumeric characters (min 6 characters)" minlength="6" name="username" class="form-control" placeholder="Username" required> -->
    <label for="password" class="sr-only">Password</label>
    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain a number, a lowercase letter and a an uppercase letter (min 6 characters)" minlength="6" id="password" name="password" class="form-control" placeholder="Password" required>
    <label for="confirm_password" class="sr-only">Confirm password</label>
    <input type="password" title="Must match the password above" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
    <br><br>
    <button name="register" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    <a href="login.php" class="btn btn-lg btn-default btn-block">Already a user? Log in!</a>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>

<?php include 'includes/footer.php'; ?>
