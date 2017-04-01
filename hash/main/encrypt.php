<?php

    if (isset($_POST['result'])) {
        if ($_POST['hash'] !== "") {
            switch ($_POST['hash_type']) {
                case 'php_hash':
                    $hash = password_hash($_POST['hash'], PASSWORD_DEFAULT);
                    break;
                case 'md5':
                    $hash = md5($_POST['hash']);
                    break;
            }
        }
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hashing simulator - Encrypt</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Hashing Simulator</h2>

        <div class="crypt">
            <a href="../index.php">Home</a>
        </div>

        <div class="crypt">
            <a href="decrypt.php">Decrypt</a>
        </div>

        <!-- -->

        <br><br>

        <form action="encrypt.php" method="post">
            <div>
                <p>
                    <label for="hash">Enter a string to hash</label>
                    <input type="text" name="hash" id="hash">
                </p>
            </div>
            <div>
                <p>
                    <label for="hash_type">Select hash type</label>
                    <select name="hash_type" id="hash_type">
                        <option value="php_hash">PHP password hash</option>
                        <option value="md5">MD5</option>
                        <option value="sha1">SHA1</option>
                    </select>
                </p>
            </div>
            <div>
                <p>
                    <input type="submit" name="result" value="Hash!">
                </p>
            </div>
        </form>

        <div>
            <p>
                ↓ Results ↓
            </p>
            <p>
                <?php if ($hash !== "") : ?>
                    <span id="api"><?php echo $hash; ?></span>
                <?php endif; ?>
            </p>
        </div>
    </div>
</body>
</html>