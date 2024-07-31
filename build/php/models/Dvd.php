<?php

class Dvd extends Product
{
    public function getAttributeDetails()
    {
        return "Size: {$this->getAttributeValue()} ".$this->getProductType()->getAttribute();
    }
}
