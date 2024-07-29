<?php require_once("../core/Init.php"); ?> 

<?php
class ProductsController
{
    private $productRepository;
    private $validator;
    /*
    * Constructor
    */
    public function __construct($productRepository, $validator)
    {
        $this->productRepository  = $productRepository;
        $this->validator = $validator;
    }

    /*
    * Getting All Products
    */
    public function getAllProducts()
    {
        try {
            $productObjects = $this->productRepository->getAllProducts();
            $products = array(); //array to get product object values

            foreach($productObjects as $product) {
                $products[] = [
                "id" => $product->getId(),
                "sku" => $product->getSku(),
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "attribute_details" => $product->getAttributeDetails(),
                "type" => $product->getProductType()->getType()
                ];
            }
            return json_encode($products);

        } catch (Exception $e) {
            http_response_code(500);
            return json_encode(['error' => 'Error fetching data from database: '.$e->getMessage()]);
        }
    }

    /*
    * Check If products Exists by sku
    */
    public function isProductExists($sku)
    {
        $sku = $this->validator->sanitize($sku);

        if (empty($sku)) {
            return json_encode(['error' => 'Invalid SKU provided']);
        }
        return json_encode(['exists' => $this->productRepository->isProductExists($sku) > 0]);
    }

    /*
    *   Adding Product Method
    */
    public function addProduct()
    {
        $product = file_get_contents('php://input'); //geting JSON object from current request
        $requiredFields = ['sku', 'name', 'price', 'product_type_id', 'attribute_value'];

        if(!$product) {
            return json_encode(["error" => "No data provided."]);
        } else {
            $product = json_decode($product, true); // decoding and converting JSON to array

            if (json_last_error() !== JSON_ERROR_NONE) {
                return json_encode(['error' => 'Invalid JSON input.']);
            } elseif(!$this->validator->isRequired($product, $requiredFields)) {
                return json_encode(['error' => 'There is required data missing. Please Check your data!']);
            } elseif(!$this->validator->isValid($product, "add")["valid"]) {
                return $this->validator->isValid($product, "add")["message"];
            }

            $product = $this->validator->sanitize($product);
        }

        return $this->productRepository->addProduct($product);
    }

    /*
    *   Delete Product Method
    */
    public function deleteProducts()
    {
        $ids = file_get_contents('php://input'); //geting JSON object from current request
        if(!$ids) {
            return json_encode(["error" => "No data provided."]);
        } else {
            $ids = json_decode($ids, true); // decoding to get the ids array

            if (json_last_error() !== JSON_ERROR_NONE) {
                return json_encode(['error' => 'Invalid JSON input.']);
            } elseif(!$this->validator->isRequired($ids)) {
                return json_encode(['error' => 'Ids data is empty.']);
            } elseif(!$this->validator->isValid($ids, "delete")["valid"]) {
                return $this->validator->isValid($ids, "delete")["message"];
            }

            $placeholders = implode(',', array_fill(0, count($ids), '?')); // preparing placeholders to be put in the repository query
            $ids = $this->validator->sanitize($ids);
        }
        return $this->productRepository->deleteProducts($ids, $placeholders);
    }

    /*
    * Get All Product Types
    */
    public function getAllTypes()
    {
        try {
            $productTypeObjects = $this->productRepository->getAllTypes();
            $productTypes = array(); //array to get productTypes object values

            foreach($productTypeObjects as $productType) {
                $productTypes[] = [
                "id" => $productType->getId(),
                "type" => $productType->getType(),
                "attribute" => $productType->getAttribute()
                ];
            }
            return json_encode($productTypes);

        } catch (Exception $e) {
            http_response_code(500);
            return json_encode(['error' => 'Error fetching data from database: '.$e->getMessage()]);
        }
    }

    /*
    * Routing function that maps each request with its appropriate function
    */
    public function handleRequest()
    {
        if(isset($_GET["method"])) {
            $methodName = $_GET["method"];
        } else {
            $methodName = "";
        }

        if(method_exists($this, $methodName)) {

            $parameters = $_REQUEST;
            unset($parameters["method"]);

            $result = $this->$methodName(...$parameters);

            echo $result;
        } else {
            echo json_encode(['error' => 'Method Not Found or Not Callable! Please check your method name']);
        }
    }
}
?> 

<?php

$init = new Init();

$respository = new ProductRepository();
$validator = new Validator();

$controller = new ProductsController($respository, $validator);
$controller->handleRequest();
