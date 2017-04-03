<?php include 'includes/header.php'; ?>

<?php

    $user = new User();

    if (!$user->isLoggedIn()) {
        Redirect::to('index.php');
    }

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {

            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password_current' => array(
                    'required' => true
                ),
                'password_new' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_new_again' => array(
                    'required' => true,
                    'matches' => 'password_new'
                )
            ));

            if ($validation->passed()) {

                if (!password_verify(Input::get('password_current'), $user->data()->password)) {
                    echo 'Your current password is wrong';
                } else {
                    $user->update(array(
                        'password' => password_hash(Input::get('password_new'), PASSWORD_DEFAULT)
                    ));

                    Session::flash('home', 'Your password has been changed');
                    Redirect::to('index.php');
                }

            } else {
                foreach($validation->errors() as $error) {
                    echo $error . '<br>';
                }
            }

        }
    }

?>

    <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Change password</h2>
        <label for="password_current" class="sr-only">Current Password</label>
        <input type="password" name="password_current" id="password_current" class="form-control" placeholder="Current Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" autofocus required>
        <label for="password_new" class="sr-only">Current Password</label>
        <input type="password" name="password_new" id="password_new" class="form-control" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" minlength="6" required>
        <label for="password_new_again" class="sr-only">Current Password</label>
        <input type="password" name="password_new_again" id="password_new_again" class="form-control" placeholder="New Password Again" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" minlength="6" required>

        <br><br>

        <button name="changepassword" class="btn btn-lg btn-primary btn-block" type="submit">Change</button>
        <a href="index.php" class="btn btn-lg btn-default btn-block">Back to home</a>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </form>

<?php include 'includes/footer.php'; ?>