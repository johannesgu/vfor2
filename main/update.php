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
                'first_name' => array(
                    'min' => 2
                ),
                'middle_name' => array(),
                'last_name' => array(
                    'min' => 2
                )
            ));

            if ($validation->passed()) {

                try {
                    $user->update(array(
                        'first_name' => Input::get('first_name'),
                        'middle_name' => Input::get('middle_name'),
                        'last_name' => Input::get('last_name'),
                    ));

                    Session::flash('home', 'Your details have been updated');
                    Redirect::to('index.php');

                } catch (Exception $e) {
                    die($e->getMessage());
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
        <h2 class="form-signin-heading">Update details</h2>
        <label for="first_name" class="sr-only">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" pattern="(.*[a-zA-Z])" autofocus value="<?php echo escape($user->data()->first_name); ?>">
        <label for="middle_name" class="sr-only">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" pattern="(.*[a-zA-Z])\s?" value="<?php echo escape($user->data()->middle_name); ?>">
        <label for="last_name" class="sr-only">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" pattern="(.*[a-zA-Z])" value="<?php echo escape($user->data()->last_name); ?>">

        <br><br>

        <button name="update" class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
        <a href="index.php" class="btn btn-lg btn-default btn-block">Back to home</a>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </form>

<?php include 'includes/footer.php'; ?>