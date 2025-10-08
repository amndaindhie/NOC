<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MySQL Dump Path
    |--------------------------------------------------------------------------
    |
    | Path to mysqldump executable. This can be overridden by MYSQLDUMP_PATH
    | environment variable. For Windows XAMPP, it might be:
    | 'C:\xampp\mysql\bin\mysqldump.exe'
    |
    | For Linux hosting, it will typically be just 'mysqldump'
    |
    */

    'mysqldump_path' => env('MYSQLDUMP_PATH', 'C:\xampp\mysql\bin\mysqldump.exe'),

    /*
    |--------------------------------------------------------------------------
    | MySQL Client Path
    |--------------------------------------------------------------------------
    |
    | Path to mysql executable for restore operations. This can be overridden
    | by MYSQL_PATH environment variable. For Windows XAMPP, it might be:
    | 'C:\xampp\mysql\bin\mysql.exe'
    |
    | For Linux hosting, it will typically be just 'mysql'
    |
    */

    'mysql_path' => env('MYSQL_PATH', 'C:\xampp\mysql\bin\mysql.exe'),
];
