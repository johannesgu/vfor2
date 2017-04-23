<?php include 'includes/header.php'; ?>

<?php

$user = new User();

if ($user->isLoggedIn()) {
    Redirect::to('index.php');
}

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

<h3>Log in</h3>

<div class="row">
    <div class="col-lg-6">
        <form class="form-vertical" role="form" action="" method="post" autocomplete="off">
            <div class="form-group">
                <label for="email" class="control-label">Email address</label>
                <input type="email" pattern="(.*\w)@(.*[a-z])\.(.*[a-z])" id="email" name="email" class="form-control" placeholder="Email address" required autofocus value="<?php echo escape(Input::get('email')); ?>">
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="checkbox">
                <label for="remember">
                    <input type="checkbox" name="remember" id="remember"> Remember me
                </label>
            </div>
            <br>
            <div class="form-group">
                <button name="login" class="btn btn-default" type="submit">Log in</button>
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
