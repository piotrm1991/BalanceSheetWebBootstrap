<?php

class FormInputDate extends FormInput
{
    public $id;

    function __construct($name, $description = '', $id, $value = '', $type = 'date', $required = true, $class = 'form-control')
    {
        $this -> name = $name;
        $this -> value = $value;
        $this -> type = $type;
        $this -> description = $description;
        $this -> required = $required;
        $this -> class = $class;
        $this -> id = $id;
    }

    function getInputHTML()
    {
        return 
        "
        <input type='$this->type' name='$this->name' value='$this->value' id='$this->id' class='$this->class'>
        ";
    }
}
?>