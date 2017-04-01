<?php include 'includes/header.php'; ?>

<?php

if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();
if ($user->isLoggedIn()) {
?>
    <p>Hello <a href="#"><?php echo escape($user->data()->email); ?></a></p>

    <ul>
        <li><a href="logout.php">Log out</a></li>
    </ul>

<?php
} else {
    echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
}
?>

<?php include 'includes/footer.php'; ?>