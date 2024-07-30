<?php

class Validator
{
    /*
    * Check if Required fields are filled
    */
    public function isRequired($data, $requiredFields = null)
    {
        if($data) {
            if(is_array($data)) {
                if($requiredFields != null) {
                    foreach($requiredFields as $field) {
                        if(!isset($data[$field]) || trim($data[$field]) == "") {
                            return false;
                        }
                    }
                } elseif($requiredFields == null) {
                    if(!isset($data) || empty($data)) {
                        return false;
                    }
                }
            } elseif(!isset($data) || trim($data) == "") {
                return false;
            }
            return true;
        }
        return false;

    }


    /*
    * Check if product fields are with valid type and value
    */
    public function isValid($data, $flag)
    {
        if($flag == "add") {

            if (!is_numeric($data['price']) || $data['price'] < 0) {
                // return (" Invalid price. It must be a positive number or equal to 0");
                return ["valid" => false, "message" => "Invalid price. It must be a positive number or equal to 0" ];
            }

            if(!preg_match('/^([1-9][0-9]*)|(?!0)([1-9][0-9]*)(x[1-9][0-9]*){2}$/', $data['attribute_value'])) {
                // return false;
                return ["valid" => false, "message" => "Invalid attribute value. It must be a positive number or in this format (100x9x50)" ];
            }

        } elseif($flag == "delete") {
            foreach ($data as $id) {
                if (!is_numeric($id) || $id < 0) {
                    return ["valid" => false, "message" => "There is invalid id in you array. It must be a positive number." ];
                }
            }
        }

        return ["valid" => true, "message" => "Values are valid" ];
    }

    /*
    * Sanitize fields
    */
    public function sanitize($data)
    {
        if($data) {
            if(is_array($data)) {
                foreach($data as $key => $value) {
                    $data[$key] = htmlspecialchars(trim($data[$key]));
                }
                return $data;
            } else {
                return htmlspecialchars(trim($data));
            }
        }
        return false;
    }
}
