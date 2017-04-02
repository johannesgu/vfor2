<?php include 'includes/header.php'; ?>

<?php

    if (!$id_user = Input::get('user')) {
        Redirect::to('index.php');
    } else {
        $user = new User($id_user);
        if (!$user->exists()) {
            Redirect::to(404);
        } else {
            $data = $user->data();
        }
?>
        <h3><?php echo escape($data->email); ?></h3>
        <p>Full Name:
        <?php echo escape($data->first_name) . ' ' . escape($data->middle_name) . ' ' . escape($data->last_name); ?>
        </p>
<?php
    }
?>
<?php include 'includes/footer.php'; ?>