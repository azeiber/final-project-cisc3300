<?php

namespace app\controllers;

use app\models\Store;

class StoreController
{
    // Validate the store suggestion input data
    public function validateStore($inputData) {
        $errors = [];
        $store_name = $inputData['store_name'];
        $store_address = $inputData['store_address'];

        if ($store_name) {
            $store_name = htmlspecialchars($store_name, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($store_name) < 1) {
                $errors['storeNameShort'] = 'Store name is too short';
            }
        } else {
            $errors['requiredStoreName'] = 'Store name is required';
        }

        if ($store_address) {
            $store_address = htmlspecialchars($store_address, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($store_address) < 2) {
                $errors['storeAddressShort'] = 'Store address is too short';
            }
        } else {
            $errors['requiredStoreAddress'] = 'Store address is required';
        }

        if (count($errors)) {
            // Send an error response in JSON format if there are validation errors
            http_response_code(400);  // Bad request
            echo json_encode($errors);
            exit();
        }
        return [
            'store_name' => $store_name,
            'store_address' => $store_address,
        ];
    }

    // Save a new store suggestion (this method is triggered via AJAX)
    public function saveStore() {
        // Get form data
        $inputData = [
            'store_name' => $_POST['store_name'] ?? false,
            'store_address' => $_POST['store_address'] ?? false,
        ];

        // Validate the input data
        $storeData = $this->validateStore($inputData);

        // Save the data to the database via the Store model
        $store = new Store();
        $store->saveStore([
            'store_name' => $storeData['store_name'],
            'store_address' => $storeData['store_address'],
        ]);

        // Send a success response back in JSON format
        http_response_code(200);  // Success
        echo json_encode([
            'success' => true
        ]);
        exit();
    }
}
