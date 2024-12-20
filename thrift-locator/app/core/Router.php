<?php

namespace app\core;

use app\controllers\MainController;
use app\controllers\ContactController;
use app\controllers\StoreController;

class Router {
    public $urlArray;

    function __construct()
    {
        // var_dump("Router initialized"); 
        $this->urlArray = $this->routeSplit();
        $this->handleMainRoutes();
        $this->handleContactRoutes();
        $this->handlePageRoutes();
        $this->handleStoreRoutes();
    }

    protected function routeSplit() {
        // Remove query parameters and split the URL into an array
        $removeQueryParams = strtok($_SERVER["REQUEST_URI"], '?');
        return explode("/", $removeQueryParams);
    }

    // // General route handler
    // protected function handleRoutes() {
    //     if (!isset($this->urlArray[0]) || $this->urlArray[0] === '') {
    //         // Default route (homepage)
    //         $this->handleMainRoutes();
    //     } elseif ($this->urlArray[0] === 'contact') {
    //         // Contact route handling
    //         $this->handleContactRoutes();
    //     } elseif ($this->urlArray[0] === 'about') {
    //         // About route handling
    //         $this->handleAboutRoutes();
    //     } else {
    //         // Handle unsupported routes
    //         $this->handleError();
    //     }
    // }

    protected function handleMainRoutes() {
        // var_dump($this->urlArray);
        if (empty($this->urlArray[0]) || isset($this->urlArray[1]) && $this->urlArray[1] === 'index.html') {
            $mainController = new MainController();
            $mainController->homepage();
        }
    }

    protected function handleContactRoutes() {
        // var_dump($this->urlArray, $_SERVER['REQUEST_METHOD']);

        $contactController = new ContactController();

        // Display contact form view (GET request)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($this->urlArray[1]) && $this->urlArray[1] === 'contact.html') {
            $contactController->contactsView();
        }

        // Add contact (POST request)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactController->saveContact();
        }

        // route to get all contacts (GET request)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($this->urlArray[2]) && $this->urlArray[2] === 'contact.html') {
            $contactController->getAllContacts();
        }

        // route to get contact by ID (GET request)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($this->urlArray[3]) && is_numeric($this->urlArray[3])) {
            $contactController->getContactById($this->urlArray[3]);
        }

        // Update contact (PUT request)
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($this->urlArray[3]) && is_numeric($this->urlArray[3])) {
            $contactController->updateContact($this->urlArray[3]);
        }

        // Delete contact (DELETE request)
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($this->urlArray[3]) && is_numeric($this->urlArray[3])) {
            $contactController->deleteContact($this->urlArray[3]);
        }
    }

     // Handle store-related routes
     protected function handleStoreRoutes() {
        // var_dump("Handling store routes");
        $storeController = new StoreController();

        var_dump($this->urlArray); 

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($this->urlArray[1]) && $this->urlArray[1] === 'random_stores') {
            $storeController->getRandomStore(); 
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($this->urlArray[1] === 'api') && $this->urlArray[2] === 'store_suggestions') {
            $storeController->addStore();
            return;
        }
    }

    // Other page routes
    protected function handlePageRoutes(): void {
        $mainController = new MainController();

         // Handle about page
         if (isset($this->urlArray[1]) && $this->urlArray[1] === 'about.html') {
            $mainController->about();
        }
        // Handle my-account page
        elseif (isset($this->urlArray[1]) && $this->urlArray[1] === 'my-account.html') {
            $mainController->myAccount();
        }
        // Handle thrift-hub page
        elseif (isset($this->urlArray[1]) && $this->urlArray[1] === 'thrift-hub.html') {
            $mainController->thriftHub();
        }
        // if ($this->urlArray[1] === 'contact' && $_SERVER['REQUEST_METHOD'] === 'GET')
        // {
        //     $mainController->contact();
        // }
    }

    // Handle errors for unsupported routes
    protected function handleError() {
        // Log error
        error_log("Error: Unsupported route accessed. URL: " . $_SERVER["REQUEST_URI"]);

        // Display custom 404 page
        include 'views/404.html'; 
        exit(); 
    }
}