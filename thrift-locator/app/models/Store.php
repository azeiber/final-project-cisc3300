<?php

namespace app\models;

// Using the database class namespace
use app\models\Model;

class Store extends Model {

    protected $table = 'store_suggestions';

    // Get all store suggestions
    public function getAllStores() {
        $query = "SELECT * FROM store_suggestions";
        return $this->fetchAll($query);  // Fetch all store suggestions from the database
    }

    // Get a store suggestion by ID
    public function getStoreById($id){
        $query = "SELECT * FROM store_suggestions WHERE id = :id";
        return $this->fetchAllWithParams($query, ['id' => $id]);  // Fetch the store suggestion by ID
    }

    // Save a new store suggestion
    public function saveStore($inputData){
        $query = "INSERT INTO store_suggestions (store_name, store_address) VALUES (:store_name, :store_address)";
        return $this->fetchAllWithParams($query, $inputData);  // Insert a new store suggestion into the database
    }
}
