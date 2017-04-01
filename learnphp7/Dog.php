<?php

class Dog {

    // Properties

    private $dog_weight = 0;
    private $dog_breed = 'no breed';
    private $dog_color = 'no color';
    private $dog_name = 'no name';
    private $dog_gender = 'no gender';
    private $error_message = '??';

    // Constructor

    function __construct($properties_array) {
        if (method_exists('dog_container', 'create_object')) {
            $name_error = $this->set_dog_name($properties_array[0]) == TRUE ? 'TRUE, ' : 'FALSE, ';
            $breed_error = $this->set_dog_breed($properties_array[1]) == TRUE ? 'TRUE, ' : 'FALSE, ';
            $color_error = $this->set_dog_color($properties_array[2]) == TRUE ? 'TRUE, ' : 'FALSE, ';
            $weight_error = $this->set_dog_weight($properties_array[3]) == TRUE ? 'TRUE, ' : 'FALSE, ';
            $gender_error = $this->set_dog_gender($properties_array[4]) == TRUE ? 'TRUE' : 'FALSE';

            $this->error_message = $name_error . $breed_error . $color_error . $weight_error . $gender_error;
        } else {
            exit;
        }
    }

    // toString

    function __toString() {
        return $this->error_message;
    }

    // Set Methods

    function set_dog_name($value) {
        $error_message = TRUE;
        (ctype_alpha($value) && strlen($value) <= 20) ? $this->dog_name = $value : $error_message = FALSE;
        return $error_message;
    }

    function set_dog_weight($value) {
        $error_message = TRUE;
        (ctype_digit($value) && ($value > 0 && $value <= 120)) ? $this->dog_weight = $value : $error_message = FALSE;
        return $error_message;
    }

    function set_dog_breed($value) {
        $error_message = TRUE;
        ((ctype_alpha($value) && ($this->validator_breed($value) === TRUE)) && strlen($value) <= 35) ? $this->dog_breed = $value : $error_message = FALSE;
        return $error_message;
    }

    function set_dog_color($value) {
        $error_message = TRUE;
        $valid_array = array("Brown", "Black", "Yellow", "White", "Mixed");
        (in_array($value, $valid_array)) ? $this->dog_color = $value : $error_message = FALSE;
        return $error_message;
    }

    function set_dog_gender($value) {
        $error_message = TRUE;
        $valid_array = array("MALE", "FEMALE");
        (in_array($value, $valid_array)) ? $this->dog_gender = $value : $error_message = FALSE;
        return $error_message;
    }

    // Get methods

    function get_dog_name() {
        return $this->dog_name;
    }

    function get_dog_weight() {
        return $this->dog_weight;
    }

    function get_dog_breed() {
        return $this->dog_breed;
    }

    function get_dog_color() {
        return $this->dog_color;
    }

    function get_dog_gender() {
        return $this->dog_gender;
    }

    function get_properties()  {
        return "$this->dog_weight, $this->dog_breed, $this->dog_color, $this->dog_gender";
    }

    // General Methods

    private function validator_breed($value) {
        $breed_file = simplexml_load_file("breeds.xml");
        $xmlText = $breed_file->asXML();

        if (stristr($xmlText, $value) === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function speak() {
        return 'Bark! <br>';
    }

}