<?php
require_once("Dog.php");

function clean_input($value) {
    $bad_chars = array("{", "}", "(", ")", ";", ":", "<", ">", "/", "$");
    $value = str_ireplace($bad_chars, "", $value);
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    return $value;
}

if (isset($_POST['dog_name']) && isset($_POST['dog_breed']) && isset($_POST['dog_color']) && isset($_POST['dog_weight']) && isset($_POST['dog_gender'])) {
    $dog_name = clean_input($_POST['dog_name']);
    $dog_breed = clean_input($_POST['dog_breed']);
    $dog_color = clean_input($_POST['dog_color']);
    $dog_weight = clean_input($_POST['dog_weight']);
    $dog_gender = clean_input($_POST['dog_gender']);

    $lab = new Dog([$dog_name, $dog_breed, $dog_color, $dog_weight, $dog_gender]);
    list($name_error, $breed_error, $color_error, $weight_error, $gender_error) = explode(', ', $lab);

    echo $name_error ? "Name Updated Successfully<br>" : "Name Update Not Successful<br>";
    echo $breed_error ? "Breed Updated Successfully<br>" : "Breed Update Not Successful<br>";
    echo $color_error ? "Color Updated Successfully<br>" : "Color Update Not Successful<br>";
    echo $weight_error ? "Weight Updated Successfully<br>" : "Weight Update Not Successful<br>";
    echo $gender_error ? "Gender Updated Successfully<br>" : "Gender Update Not Successful<br>";

    $dog_properties = $lab->get_properties();
    list($dog_weight, $dog_breed, $dog_color, $dog_gender) = explode(", ", $dog_properties);
    echo "Dog weight is $dog_weight. Dog breed is $dog_breed. Dog color is $dog_color. Dog gender is $dog_gender";
} else {
    echo "<p>Missing or invalid parameters. Please go back to the lab.html page to enter valid information.</p><br>";
    echo "<a href='lab.html'>Dog Creation Page</a>";
}


