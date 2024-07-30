<?php

class FurnitureFactory implements ProductFactory
{
    public function createProduct()
    {
        return new Furniture();
    }
}
