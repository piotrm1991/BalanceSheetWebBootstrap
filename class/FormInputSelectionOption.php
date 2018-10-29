<?php

class FormInputSelectionOption
{
    public $name;
    public $value;
    public $description;

    function __construct($name, $value, $description)
    {
        $this -> name = $name;
        $this -> value = $value;
        $this -> description = $description;
    }

    function getInputHTML()
    {
        return 
        "
        <option value='$this->value'>$this->description</option>
        ";
    }
}
?>