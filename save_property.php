<?php
include("db.php");

if(isset($_POST["save_property"])){

    $property_title = $_POST["title"];
    $property_description = $_POST["description"];

    $query = "INSERT INTO property (title, description) VALUES ('$property_title', '$property_description')";
    $result = mysqli_query($conn, $query);

    if($result){
        echo "Property saved successfully.";
    } else {
        echo "Error saving property: " . mysqli_error($conn);
    }
}
?>