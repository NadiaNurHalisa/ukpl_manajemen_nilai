<?php
require_once __DIR__ . '/../database.php';

function getStudents() {
    global $pdo;
    $stmt = $pdo->query("SELECT students.*, classes.name AS class_name FROM students JOIN classes ON students.class_id = classes.id");
    return $stmt->fetchAll();
}

function getStudentById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createStudent($full_name, $email, $class_id) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO students (full_name, email, class_id) VALUES (?, ?, ?)");
    return $stmt->execute([$full_name, $email, $class_id]);
}

function updateStudent($id, $full_name, $email, $class_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE students SET full_name = ?, email = ?, class_id = ? WHERE id = ?");
    return $stmt->execute([$full_name, $email, $class_id, $id]);
}

function deleteStudent($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    return $stmt->execute([$id]);
}
?>
