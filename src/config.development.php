<?php

/**
 * PHPMaker 2022 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "162.214.54.19", "port" => "3306", "user" => "mas_admin_dev", "password" => "#Fun2See#", "dbname" => "mas_admin_dev"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "mail.masmartialarts.com", // SMTP server
        "SERVER_PORT" => 465, // SMTP server port
        "SECURE_OPTION" => "ssl",
        "SERVER_USERNAME" => "noreply@masmartialarts.com", // SMTP server user name
        "SERVER_PASSWORD" => "#n0r3plym4sm4rt14l4rt5#", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "NVhPtqf15jAqX3xv", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
