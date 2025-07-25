<?php
$env = parse_ini_file('.env');

$conn = new mysqli(
    $env['DB_HOST'],
    $env['DB_USERNAME'],
    $env['DB_PASSWORD'],
    $env['DB_DATABASE'],
    $env['DB_PORT']
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
