<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "checkout_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$country = $_POST['country'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$zip = $_POST['zip'];
$city = $_POST['city'];
$state = $_POST['state'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$sql = "INSERT INTO shipping_details (country, fname, lname, address1, address2, zip, city, state, phone, email)
VALUES ('$country', '$fname', '$lname', '$address1', '$address2', '$zip', '$city', '$state', '$phone', '$email')";

if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo "error";
}

$conn->close();
?>
