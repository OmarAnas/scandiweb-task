<?php

class Furniture extends Product
{
    public function getAttributeDetails()
    {
        return "Dimension: {$this->getAttributeValue()}";
    }
}
