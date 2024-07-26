<?php

// Database Configuration
const DB_HOST = "127.0.0.1";
const DB_NAME = "bangubank";
const DB_USER = "root";
const DB_PASS = "";

// Configuration Array
return [
    // Storage Option: "file" or "database"
    "storage"  => "database",

    // Database Connection Details
    "database" => [
        "dsn"      => "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        "username" => DB_USER,
        "password" => DB_PASS,
    ],
];