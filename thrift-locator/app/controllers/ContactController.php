<?php

namespace app\controllers;

use app\models\Contact;

class ContactController extends Controller
{
    public function contact() {
        include 'views/contact.html';
        $this->returnView('./assets/views/contact.html');
    }

    // Validation function for contact data
    public function validateContact($inputData) {
        $errors = [];
        $firstName = $inputData['first_name'];
        $lastName = $inputData['last_name'];
        $email = $inputData['email'];
        $messages = $inputData['messages'];

        // Validate first name
        if ($firstName) {
            $firstName = htmlspecialchars($firstName, ENT_QUOTES | ENT_HTML5, 'UTF-8', true);
            if (strlen($firstName) < 2) {
                $errors['firstNameShort'] = 'First name is too short';
            }
        } else {
            $errors['requiredFirstName'] = 'First name is required';
        }

        // Validate last name
        if ($lastName) {
            $lastName = htmlspecialchars($lastName, ENT_QUOTES | ENT_HTML5, 'UTF-8', true);
            if (strlen($lastName) < 2) {
                $errors['lastNameShort'] = 'Last name is too short';
            }
        } else {
            $errors['requiredLastName'] = 'Last name is required';
        }

        // Validate email
        if ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['invalidEmail'] = 'Invalid email address';
            }
        } else {
            $errors['requiredEmail'] = 'Email is required';
        }

        // Validate message
        if (!$messages) {
            $errors['requiredMessage'] = 'Message is required';
        }

        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'messages' => $messages,
        ];
    }

    // Get all contacts
    public function getAllContacts() {
        $contactModel = new Contact();
        header("Content-Type: application/json");
        $contacts = $contactModel->getAllContacts();
        // var_dump($contact);
        echo json_encode($contacts);
        include '/assets/views/index.html';
        // exit();
    }

    // Get contact by ID
    public function getContactById($id) {
        $contactModel = new Contact();
        header("Content-Type: application/json");
        $contact = $contactModel->getContactById($id);
        echo json_encode($contact);
        exit();
    }

    // Save new contact
    public function saveContact() {
        $inputData = [
            'first_name' => $_POST['first_name'] ? $_POST['first_name'] : false,
            'last_name' => $_POST['last_name'] ? $_POST['last_name'] : false,
            'email' => $_POST['email'] ? $_POST['email'] : false,
            'messages' => $_POST['messages'] ? $_POST['messages'] : false,
        ];

        $contactData = $this->validateContact($inputData);

        $contact = new Contact();
        $contact->saveContact(
            [
                'first_name' => $contactData['first_name'],
                'last_name' => $contactData['last_name'],
                'email' => $contactData['email'],
                'messages' => $contactData['messages'],
            ]
        );

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    // Update contact by ID
    public function updateContact($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        // Parse PUT request data
        parse_str(file_get_contents('php://input'), $_PUT);

        $inputData = [
            'first_name' => $_PUT['first_name'] ? $_PUT['first_name'] : false,
            'last_name' => $_PUT['last_name'] ? $_PUT['last_name'] : false,
            'email' => $_PUT['email'] ? $_PUT['email'] : false,
            'messages' => $_PUT['messages'] ? $_PUT['messages'] : false,
        ];

        $contactData = $this->validateContact($inputData);

        $contact = new Contact();
        $contact->updateContact(
            [
                'id' => $id,
                'first_name' => $contactData['first_name'],
                'last_name' => $contactData['last_name'],
                'email' => $contactData['email'],
                'messages' => $contactData['messages'],
            ]
        );

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    // Delete contact by ID
    public function deleteContact($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        $contact = new Contact();
        $contact->deleteContact(
            [
                'id' => $id,
            ]
        );

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    public function contactsView() {
        include './assets/views/contact.html';
        // $this->returnView('./assets/views/contact.html');
        exit();
    }

    // public function contactsAddView() {
    //     include '../public/assets/views/contact/contact-add.html';
    //     exit();
    // }

    // public function contactsDeleteView() {
    //     include '../public/assets/views/contact/contact-delete.html';
    //     exit();
    // }

    // public function contactsUpdateView() {
    //     include '../public/assets/views/contact/contact-update.html';
    //     exit();
    // }
}
