<?php

namespace app\models;

use app\models\Model;

class Store extends Model {

    protected $table = 'store_suggestions';

    // Add a new store suggestion
    public function addStore($data) {
        $query = "INSERT INTO $this->table (store_name, store_address) VALUES (:store_name, :store_address)";
        try {
            // Execute the insert query
            $this->query($query, $data);  // This will execute the query

            // Get the last inserted ID to confirm the record was created
            $store_id = $this->db->lastInsertId();  // Get the last inserted ID
            
            if (!$store_id) {
                // If no ID is returned, output an error and debug the issue
                throw new Exception("Failed to get last insert ID. No rows inserted.");
            }

            // Return the store ID if the insert is successful
            return $store_id;
        } catch (Exception $e) {
            // If there was an error during the insert or retrieving the ID, handle it
            echo json_encode(['error' => 'Error occurred while creating store', 'message' => $e->getMessage()]);
            exit();
        }
    }

    // Get a random store suggestion
    public function getRandomStore() {
        $query = "SELECT store_name, store_address FROM store_suggestions ORDER BY RAND() LIMIT 1";
        return $this->fetchAll($query);  // Fetch a random store suggestion
    }
}


// namespace app\models;

// Using the database class namespace
// use app\models\Model;

// class Store extends Model {

//     protected $table = 'store_suggestions';

    // // Get all store suggestions
    // public function getAllStores() {
    //     $query = "SELECT * FROM store_suggestions";
    //     return $this->fetchAll($query);  // Fetch all store suggestions from the database
    // }

    // // Get a store suggestion by ID
    // public function getStoreById($id){
    //     $query = "SELECT * FROM store_suggestions WHERE id = :id";
    //     return $this->fetchAllWithParams($query, ['id' => $id]);  // Fetch the store suggestion by ID
    // }

    // // Save a new store suggestion
    // public function saveStore($inputData){
    //     $query = "INSERT INTO store_suggestions (store_name, store_address) VALUES (:store_name, :store_address)";
    //     return $this->fetchAllWithParams($query, $inputData);  // Insert a new store suggestion into the database
    // }


    // public function addStore($data){
    //     $query = "INSERT INTO store_suggestions (store_name, store_address) VALUES (:store_name, :store_address)";
    //     try {
    //         $this->query($query, $data);
    //     }
    //     return $this->fetchAllWithParams($query, $inputData);  // Insert a new store suggestion into the database
    // }

    // Get a random store suggestion
    // public function getRandomStore() {
    //     $query = "SELECT store_name, store_address FROM random_stores ORDER BY RAND() LIMIT 1";
    //     return $this->fetchAll($query);  // Fetch a random store suggestion
    // }
// }
