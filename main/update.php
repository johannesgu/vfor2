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

    <h3>Update details</h3>

    <div class="row">
        <div class="col-lg-6">
            <form class="form-vertical" role="form" action="" method='post' autocomplete="off">
                <div class="form-group">
                    <label for="first_name" class="control-label">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" pattern="(.*[a-zA-Z])" autofocus value="<?php echo escape($user->data()->first_name); ?>">
                </div>
                <div class="form-group">
                    <label for="middle_name" class="control-label">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" pattern="(.*[a-zA-Z])\s?" value="<?php echo escape($user->data()->middle_name); ?>">
                </div>
                <div class="form-group">
                    <label for="last_name" class="control-label">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" pattern="(.*[a-zA-Z])" value="<?php echo escape($user->data()->last_name); ?>">
                </div>

                <button name="update" class="btn btn-default" type="submit">Update</button>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            </form>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>