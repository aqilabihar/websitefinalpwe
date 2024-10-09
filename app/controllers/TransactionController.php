<?php

namespace App\Controllers;

class TransactionController {
    public function index() {
        // Load the transaction view
        include_once '../app/views/transaction.php';
    }
}