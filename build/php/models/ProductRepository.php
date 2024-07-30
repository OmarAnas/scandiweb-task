<?php

class ProductRepository
{
    private $db;
    private $factories;

    /*
    *  Constructor
    */
    public function __construct()
    {
        $this->db = new DatabaseHelper();
        $this->factories = [
            "book" => new BookFactory(),
             "furniture" => new FurnitureFactory(),
             "dvd" => new DvdFactory()
        ];
    }

    /*
    * Getting all products and setting them to be Objects of type Product
    */
    public function getAllProducts()
    {
        $query = $this->db->select("*")->from("products");

        $productSet = $this->db->query()->execute()->multipleResults();

        $products = array(); // array of products objects

        foreach ($productSet as $productData) {
            $products[] = $this->createProductObject($productData);
        }

        return $products;
    }

    /*
    * Check if product exists by sku
    */
    public function isProductExists($sku)
    {
        $query = $this->db->select("id")->from("products")->where("sku", "=", ":sku");

        $this->db->query()->bind(["sku" => $sku])->execute()->singleResult();

        return $this->db->rowCount();
    }

    /*
    *   Adding Product Method
    */
    public function addProduct($product)
    {
        $product = $this->createProductObject($product);

        $data = ["sku" => $product->getSku(), "name" => $product->getName(),
                "price" => $product->getPrice(), "attribute_value" => $product->getAttributeValue(),
                "product_type_id" => $product->getProductTypeId()];

        $query = $this->db->insert('products', array_keys($data));

        return $this->db->query()->bind($data)->execute();
    }

    /*
    *   Deleting Products Method
    */
    public function deleteProducts($ids, $placeholders)
    {
        $query = $this->db->delete()->from('products')->where('id', 'IN', $placeholders);

        return $this->db->query()->execute($ids);
    }

    /*
    * Getting All Product Types
    */
    public function getAllTypes()
    {
        $query = $this->db->select("*")->from("product_type");

        $productTypeSet = $this->db->query()->execute()->multipleResults();

        $productTypes = array(); // array of ProductType objects

        foreach ($productTypeSet as $typeData) {
            $productTypes[] = $this->createProductTypeObject($typeData);
        }
        return $productTypes;
    }

    /*
    * Getting Product Type by Id
    */
    public function getTypeById($id)
    {
        $query = $this->db->select("*")->from("product_type")->where("id", "=", ":id");

        $productType = $this->db->query()->bind(["id" => $id])->execute()->singleResult();

        $productType = $this->createProductTypeObject($productType);

        return $productType;
    }

    /*
    * Creating an Object of Type Product
    */
    private function createProductObject($productData)
    {
        $productType = $this->getTypeById($productData['product_type_id']);

        $factory = $this->getFactory($productType->getType());
        $product = $factory->createProduct();

        $product->setId($productData['id']);
        $product->setSku($productData['sku']);
        $product->setName($productData['name']);
        $product->setPrice($productData['price']);
        $product->setAttributeValue($productData['attribute_value']);
        $product->setProductTypeId($productData['product_type_id']);

        $product->setProductType($productType);

        return $product;
    }

    /*
    * Creating an Object of Type ProductType
    */
    private function createProductTypeObject($typesData)
    {
        $productType = new ProductType();
        $productType->setId($typesData['id']);
        $productType->setType($typesData['type']);
        $productType->setAttribute($typesData['attribute']);

        return $productType;
    }

    /*
    * Intializing Factory Object according to Product Type
    */
    private function getFactory($type)
    {
        $type = strtolower($type);
        if(!isset($this->factories[$type])) {
            throw new InvalidArgumentException("No factory for type: {$type}");
        }
        return $this->factories[$type];
    }

}
