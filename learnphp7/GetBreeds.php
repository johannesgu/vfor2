<?php

class GetBreeds {

    function __construct($properties_array) {
        if (!(method_exists('dog_container', 'create_object'))) {
            exit;
        }
    }

    private $result = "??";

    public function get_select($dog_app) {
        if (($dog_app != FALSE) && (file_exists($dog_app))) {
            $breed_file = simplexml_load_file("breeds.xml");
            $xmlText = $breed_file->asXML();

            $this->result = "<select name='dog_breed' id='dog_breed' required>";
            $this->result .= "<option value='-1' selected>Select a dog breed</option>";
            foreach ($breed_file->children() as $name => $value) {
                $this->result .= "<option value='$value'>$value</option>";
            }
            $this->result .= "</select>";

            return $this->result;
        } else {
            return FALSE;
        }
    }

}
