<?php

class IncomeCategoryNames extends GetNames
{
    private $namesTranslated;

    function __construct($dbo, $loggedId)
    {
        $this->dbo = $dbo;
        $this->loggedId = $loggedId;
        $this->names = $this->setNames();
        $this->namesTranslated = $this->names;
        $this->translateIncomeCategory();
    }

    function setNames()
    {
        $names = $this->dbo->getIncomeNames($this->loggedId);
        return $names;
    }

    function translateIncomeCategory()
    {
        $categories = new Categories();
        $names = $categories->getIncomeCategories();
        foreach ($this->namesTranslated as &$translated) {
            foreach ($names as $name=>$name_meaning) {
                if ($translated['name']==$name) {
                    $translated['name'] = $name_meaning;
                    break;
                }
            }
        }
    }

    function getNamesTranslated()
    {
        return $this->namesTranslated;
    }

    function getNames()
    {
        return $this->names;
    }
}