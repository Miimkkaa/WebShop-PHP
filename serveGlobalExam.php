<?php

// Client information
$server = [
    'Host server name' => $_SERVER['SERVER_NAME'],
    'Host header' => $_SERVER['HTTP_HOST'],
    'Server Software' => $_SERVER['SERVER_SOFTWARE'],
    'Document Root' => $_SERVER['DOCUMENT_ROOT']
];

print_r($server);

echo "<br>";
echo "<br>";
echo "<br>";

// Client information
$client = [
    'Client System Info' => $_SERVER['HTTP_USER_AGENT'],
    'Client IP' => $_SERVER['REMOTE_ADDR'],
    'Remote port' => $_SERVER['REMOTE_PORT'],
];

print_r($client);
