<?php

class DvdFactory implements ProductFactory
{
    public function createProduct()
    {
        return new Dvd();
    }
}
