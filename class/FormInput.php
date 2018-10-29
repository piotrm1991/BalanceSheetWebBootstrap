<?php

class FormInput
{
    public $name;
    public $value;
    public $class;
    public $placeholder;
    public $type;
    public $description;
    public $required;
    public $addon;

    function __construct($name, $placeholder = '', $description = '', $addon = '', $value = '', $type = 'text', $required = true, $class = 'form-control')
    {
        $this -> name = $name;
        $this -> value = $value;
        $this -> placeholder = $placeholder;
        $this -> type = $type;
        $this -> description = $description;
        $this -> required = $required;
        $this -> class = $class;
        $this -> addon = $addon;
    }

    function getInputHTML()
    {
        return 
        "
        <div class='input-group'>
            <span class='input-group-addon'><i class='$this->addon'></i></span>
            <input type='$this->type' name='$this->name' value='$this->value' placeholder='$this->placeholder' class='$this->class'>
        </div>	
        ";
    }
}
?>
