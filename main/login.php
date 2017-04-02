<?php include 'includes/header.php'; ?>

<?php

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array('required' => true),
            'password' => array('required' => true)
        ));

        if ($validation->passed()) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('email'), Input::get('password'), $remember);

            if ($login) {
                Redirect::to('index.php');
            } else {
                echo '<p>Sorry, logging in failed</p>';
            }

        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }

    }
}

?>

<form class="form-signin" action="" method="post" autocomplete="off">
    <h2 class="form-signin-heading">Please log in <i class="glyphicon glyphicon-music"></i></h2>
    <label for="email" class="sr-only">Email address</label>
    <input type="email" pattern="(.*\w)@(.*[a-z])\.(.*[a-z])" id="email" name="email" class="form-control" placeholder="Email address" required autofocus value="<?php echo escape(Input::get('email')); ?>">
    <label for="password" class="sr-only">Password</label>
    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" id="password" name="password" class="form-control" placeholder="Password" required>
    <div class="checkbox">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember"> Remember me
        </label>
    </div>
    <button name="login" class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
    <a href="register.php" class="btn btn-lg btn-default btn-block">New on this site? Register!</a>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>

<?php include 'includes/footer.php'; ?>
