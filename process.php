<?php
session_start();
require_once 'config.php';

// Fonction utilitaire pour les messages
function set_message($msg, $type = 'success') {
    $_SESSION['message'] = $msg;
    $_SESSION['msg_type'] = $type;
}

// CREATE
if (isset($_POST['save'])) {
    $stmt = $mysqli->prepare("INSERT INTO data (name, location) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['name'], $_POST['location']);
    $stmt->execute() ? set_message("Record saved!") : set_message($mysqli->error, "danger");
}

// DELETE
if (isset($_GET['delete'])) {
    $stmt = $mysqli->prepare("DELETE FROM data WHERE id=?");
    $stmt->bind_param("i", $_GET['delete']);
    $stmt->execute() ? set_message("Record deleted!", "danger") : set_message($mysqli->error, "danger");
}

// UPDATE
if (isset($_POST['update'])) {
    $stmt = $mysqli->prepare("UPDATE data SET name=?, location=? WHERE id=?");
    $stmt->bind_param("ssi", $_POST['name'], $_POST['location'], $_POST['id']);
    $stmt->execute() ? set_message("Record updated!", "warning") : set_message($mysqli->error, "danger");
}

// Fermeture et redirection
if (isset($stmt)) $stmt->close();
header('Location: index.php');
exit();
?>