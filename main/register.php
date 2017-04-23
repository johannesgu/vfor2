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
            'email' => array(
                'required' => true,
                'unique' => 'users'
            ),
            'username' => array(
                'required' => true,
                'min' => true,
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
                    'username' => Input::get('username'),
                    'password' => Hash::password(Input::get('password'))
                ));

                Session::flash('info', 'Your account has been registered and you can now log in');
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

<h3>Register</h3>

<div class="row">
    <div class="col-lg-6">
        <form class="form-vertical" role="form" action="" method='post' autocomplete="off">
            <div class="form-group">
                <label for="email" class="control-label">Email address</label>
                <input type="email" pattern="(.*\w)@(.*[a-z])\.(.*[a-z])" title="'example@example.com'" id="email" name="email" class="form-control" placeholder="Email address" required autofocus value="<?php echo escape(Input::get('email')); ?>">
            </div>
            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" id="username" pattern="(?=.*\w).{6,}" title="Must have alphanumeric characters (min 6 characters)" minlength="6" name="username" class="form-control" placeholder="Username" required value="<?php echo escape(Input::get('username')); ?>">
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain a number, a lowercase letter and a an uppercase letter (min 6 characters)" minlength="6" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password" class="control-label">Confirm password</label>
                <input type="password" title="Must match the password above" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
            </div>
            <br>
            <button name="register" class="btn btn-default" type="submit">Register</button>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
