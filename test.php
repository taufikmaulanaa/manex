<?php

$conn = new mysqli("ebudget.otsuka.co.id", "sadmin", "p455w0rd", "otsuka_budget"); if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); } echo "Connected successfully";

// $conn = new mysqli('ebudget.otsuka.co.id', 'sadmin', 'p455w0rd', 'otsuka_budget');

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";
// $conn->close();
?>
