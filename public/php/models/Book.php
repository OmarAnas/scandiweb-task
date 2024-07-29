<?php

class Book extends Product
{
    public function getAttributeDetails()
    {
        return "Weight: {$this->getAttributeValue()} ".$this->getProductType()->getAttribute();
    }
}
