<?php
$Host = "localhost";
$Username = "root";
$Password = "";
$DB = "alquiloapp";

$conn = mysqli_connect($Host, $Username, $Password, $DB);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";

?>