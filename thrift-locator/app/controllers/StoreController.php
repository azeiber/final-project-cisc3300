<?php

namespace app\controllers;

use app\models\Store;

class StoreController {

    // Get all stores
    public function getAllStores() {
        $storeModel = new Store();
        $stores = $storeModel->getAllStores();  // Assuming a method exists in the Store model to get all stores
        header('Content-Type: application/json');
        echo json_encode($stores);
        exit();
    }
    
    // Add a new store
    public function addStore() {
        // Read the raw JSON data from the request body
        $data = json_decode(file_get_contents('php://input'), true);
    
        // Ensure the data was parsed correctly and contains the necessary fields
        if (!$data || !isset($data['store_name']) || !isset($data['store_address'])) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Store name and address are required']);
            exit();
        }
    
        // Validate the store name and address
        $store_name = $data['store_name'];
        $store_address = $data['store_address'];

        if (strlen($store_name) < 1) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Store name is too short']);
            exit();
        }

        if (strlen($store_address) < 2) {
            http_response_code(400); // Bad request
            echo json_encode(['error' => 'Store address is too short']);
            exit();
        }
    
        // Add the store using the model
        $storeModel = new Store();
        $storeModel->addStore([
            'store_name' => htmlspecialchars($store_name),
            'store_address' => htmlspecialchars($store_address)
        ]);
    
        // Get the last inserted store ID
        $store_id = $storeModel->lastInsertId();
    
        // Return success response with the store ID
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'store_id' => $store_id
        ]);
        exit();
    }

    // Method to get a random store
    public function getRandomStore() {
        // Create an instance of the Store model
        $storeModel = new Store();

        // Get the random store from the model
        $store = $storeModel->getRandomStore();

        // Return the store as a JSON response
        header('Content-Type: application/json');
        echo json_encode($store);
        exit();
    }
}


// namespace app\controllers;

// use app\models\Store;

// class StoreController
// {
//     // Validate the store suggestion input data
//     public function validateStore($inputData) {
//         $errors = [];
//         $store_name = $inputData['store_name'];
//         $store_address = $inputData['store_address'];

//         if ($store_name) {
//             $store_name = htmlspecialchars($store_name, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
//             if (strlen($store_name) < 1) {
//                 $errors['storeNameShort'] = 'Store name is too short';
//             }
//         } else {
//             $errors['requiredStoreName'] = 'Store name is required';
//         }

//         if ($store_address) {
//             $store_address = htmlspecialchars($store_address, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
//             if (strlen($store_address) < 2) {
//                 $errors['storeAddressShort'] = 'Store address is too short';
//             }
//         } else {
//             $errors['requiredStoreAddress'] = 'Store address is required';
//         }

//         if (count($errors)) {
//             // Send an error response in JSON format if there are validation errors
//             http_response_code(400);  // Bad request
//             echo json_encode($errors);
//             exit();
//         }
//         return [
//             'store_name' => $store_name,
//             'store_address' => $store_address,
//         ];
//     }

//     // Save a new store suggestion (this method is triggered via AJAX)
//     public function saveStore() {
//         // Get form data
//         $inputData = [
//             'store_name' => $_POST['store_name'] ?? false,
//             'store_address' => $_POST['store_address'] ?? false,
//         ];

//         // Validate the input data
//         $storeData = $this->validateStore($inputData);

//         // Save the data to the database via the Store model
//         $store = new Store();
//         $store->saveStore([
//             'store_name' => $storeData['store_name'],
//             'store_address' => $storeData['store_address'],
//         ]);

//         // Send a success response back in JSON format
//         http_response_code(200);  // Success
//         echo json_encode([
//             'success' => true
//         ]);
//         exit();
//     }

//     // Method to get a random store
//     public function getRandomStore() {
//         // Create an instance of the Store model
//         $storeModel = new Store();

//         // Get the random store from the model
//         $store = $storeModel->getRandomStore();

//         // Return the store as a JSON response
//         echo json_encode($store);
//     }
// }
