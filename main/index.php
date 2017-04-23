<?php include 'includes/header.php'; ?>

<?php
    if (Session::exists('info')) {
        ?>
            <div class="alert alert-info" role="alert">
                <?php echo Session::flash('info'); ?>
            </div>
        <?php
    }
?>

<h3>Welcome to Pitchy</h3>
<p>The best music social network, like... ever</p>

<?php include 'includes/footer.php'; ?>