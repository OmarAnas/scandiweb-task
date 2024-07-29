<?php

class ProductType
{
    private $id;
    private $type;
    private $attribute;

    /*
    * Constructor
    */
    public function __construct()
    {

    }

    /*
    * Setters
    */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /*
    * Getters
    */
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }
}
