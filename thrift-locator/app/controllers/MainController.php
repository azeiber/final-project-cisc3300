<?php

namespace app\controllers;

class MainController extends Controller 
{

    public function homepage() {
        //remember to route relative to index.php
        //require page and exit to return an HTML page
        $this->returnView('./assets/views/index.html');
    }

    public function about(): void {
        $this->returnView(pathToView: './assets/views/about.html');
    }

    public function myAccount(): void {
        $this->returnView(pathToView: './assets/views/my-account.html');
    }

    public function thriftHub(): void {
        $this->returnView(pathToView: './assets/views/thrift-hub.html');
    }
    // public function contact(): void {
    //     $this->returnView(pathToView: './assets/views/contact.html');
    // }

    // public function about(): void {
    //     $this->returnView(pathToView: './assets/views/about.html');
    // }
}