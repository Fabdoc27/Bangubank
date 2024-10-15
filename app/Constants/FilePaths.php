<?php

namespace App\Constants;

final class FilePaths
{
    const TRANSACTIONS = __DIR__ . DIRECTORY_SEPARATOR . '../../data/transactions.json';
    const USERS = __DIR__ . DIRECTORY_SEPARATOR . '../../data/users.json';
    const CONFIG = __DIR__ . DIRECTORY_SEPARATOR . '../../Config/database.php';
    const LOGS = __DIR__ . DIRECTORY_SEPARATOR . '../../logs/error.log';
}
