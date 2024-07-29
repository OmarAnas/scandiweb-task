<?php

abstract class Product
{
    private $id;
    private $sku;
    private $name;
    private $price;
    private $attribute_value;
    private $product_type_id;
    private $productType;

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
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function setAttributeValue($value)
    {
        $this->attribute_value = $value;
    }
    public function setProductTypeId($id)
    {
        $this->product_type_id = $id;
    }
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    /*
    * Getters
    */
    public function getId()
    {
        return $this->id;
    }
    public function getSku()
    {
        return $this->sku;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getAttributeValue()
    {
        return $this->attribute_value;
    }
    public function getProductTypeId()
    {
        return $this->product_type_id;
    }
    public function getProductType()
    {
        return $this->productType;
    }

    /*
    * Functions
    */
    public function getAttributeDetails()
    {
    }
}
