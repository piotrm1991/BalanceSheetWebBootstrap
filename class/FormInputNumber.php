<?php

class FormInputNumber extends FormInput
{
    public $step;

    function __construct($name, $description, $placeholder = '0,00', $value = '', $type = 'number', $required = true, $class='form-control', $step = '0.01')
    {
        $this -> name = $name;
        $this -> value = $value;
        $this -> type = $type;
        $this -> description = $description;
        $this -> required = $required;
        $this -> class = $class;
        $this -> placeholder = $placeholder;
        $this -> step = $step;
    }

    function getInputHTML()
    {
        return 
        "
        <input type='$this->type' name='$this->name' value='$this->value' placeholder='$this->placeholder' class='$this->class' step='$this->step'>
        ";
    }
}
?>