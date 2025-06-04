<?php
require_once __DIR__ . '/../database.php';

function getClasses() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM classes");
    return $stmt->fetchAll();
}

function getClassById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createClass($name, $description) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO classes (name, description) VALUES (?, ?)");
    return $stmt->execute([$name, $description]);
}

function updateClass($id, $name, $description) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE classes SET name = ?, description = ? WHERE id = ?");
    return $stmt->execute([$name, $description, $id]);
}

function deleteClass($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM classes WHERE id = ?");
    return $stmt->execute([$id]);
}
?>
