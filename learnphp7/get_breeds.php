<?php

$breed_file = simplexml_load_file("breeds.xml");
$xmlText = $breed_file->asXML();

echo "<select name='dog_breed' id='dog_breed' required>";
echo "<option>Select a dog breed</option>";
foreach ($breed_file->children() as $name => $value) {
    echo "<option value='$value'>$value</option>";
}
echo "</select>";
