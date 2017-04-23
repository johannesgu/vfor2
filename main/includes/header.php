<?php

require_once '../core/init.php';

$user = new User();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../music.ico">

    <title>Pitchy</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#response" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Pitchy</a>
        </div>
        <div class="collapse navbar-collapse" id="response">
            <?php if ($user->isLoggedIn()) : ?>
            <ul class="nav navbar-nav">
                <li><a href="#">Timeline</a></li>
                <li><a href="#">Friends</a></li>
            </ul>
            <form action="#" role="search" class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" name="query" class="form-control" placeholder="Find people">
                    <button type="submit" class="btn btn-default">Search</button>
                </div>
            </form>
            <?php endif; ?>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($user->isLoggedIn()) : ?>
                    <li><a href="#"><?php echo $user->getNameOrUsername(); ?></a></li>
                    <li><a href="#">Update profile</a></li>
                    <li><a href="logout.php">Log out</a></li>
                <?php else : ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Log in</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">