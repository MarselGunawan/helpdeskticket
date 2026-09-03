<?php

require_once "config/database.php";


// ==============================
// Get ID
// ==============================

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;


// ==============================
// Validate ID
// ==============================

if ($id <= 0) {

    header("Location: index.php");

    exit;

}


// ==============================
// Delete Ticket
// ==============================

$sql = "DELETE FROM tickets WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();


// ==============================
// Back to Ticket List
// ==============================

header("Location: index.php");

exit;