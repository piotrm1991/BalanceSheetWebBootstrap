<?php

class FormTextareaInput
{
    public $name;
    public $value;
    public $class;
    public $description;
    public $required;
    public $rows;
    public $placeholder;
    
    function __construct($name, $description, $rows, $placeholder, $value = '', $required = false, $class = 'form-control')
    {
        $this -> name = $name;
        $this -> value = $value;
        $this -> description = $description;
        $this -> required = $required;
        $this -> class = $class;
        $this -> rows = $rows;
        $this -> placeholder = $placeholder;
    }
    
    function getInputHTML()
    {
        return
        "
        <div class='input-group'>
            <span class='input-group-addon'>$this->description</span>
            <textarea name='$this->name' value='$this->value' placeholder='$this->placeholder' class='$this->class' rows='$this->rows'></textarea>
        </div>
        ";
    }
}
?>