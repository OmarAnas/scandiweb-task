<?php

class BookFactory implements ProductFactory
{
    public function createProduct()
    {
        return new Book();
    }
}
