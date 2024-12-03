<?php

namespace app\models;

use app\models\Model;

class Contact extends Model {

    protected $table = 'contact'; 

    // Get all contacts 
    public function getAllContacts() {
        $query = "SELECT * FROM $this->table";
        return $this->fetchAll($query);
    }

    // Get contact by ID
    public function getContactById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        return $this->fetchAllWithParams($query, ['id' => $id]);
    }

    // Save new contact entry
    public function saveContact($inputData) {
        $query = "INSERT INTO $this->table (first_name, last_name, email, messages) 
                  VALUES (:first_name, :last_name, :email, :messages)";
        return $this->fetchAllWithParams($query, $inputData);
    }

    // Update existing contact
    public function updateContact($inputData) {
        $query = "UPDATE $this->table SET first_name = :first_name, last_name = :last_name, 
                  email = :email, messages = :messages WHERE id = :id";
        return $this->fetchAllWithParams($query, $inputData);
    }

    // Delete contact entry
    public function deleteContact($inputData) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        return $this->fetchAllWithParams($query, $inputData);
    }
}
