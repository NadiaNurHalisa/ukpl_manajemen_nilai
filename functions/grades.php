<?php
require_once __DIR__ . '/../database.php';

function getGrades() {
    global $pdo;
    $stmt = $pdo->query("SELECT grades.*, students.full_name FROM grades JOIN students ON grades.student_id = students.id");
    return $stmt->fetchAll();
}

function getGradeById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM grades WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createGrade($student_id, $subject, $score) {
    global $pdo;
    $grade_point = calculateGradePoint($score);
    $stmt = $pdo->prepare("INSERT INTO grades (student_id, subject, score, grade_point) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$student_id, $subject, $score, $grade_point]);
}

function updateGrade($id, $subject, $score) {
    global $pdo;
    $grade_point = calculateGradePoint($score);
    $stmt = $pdo->prepare("UPDATE grades SET subject = ?, score = ?, grade_point = ? WHERE id = ?");
    return $stmt->execute([$subject, $score, $grade_point, $id]);
}

function deleteGrade($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM grades WHERE id = ?");
    return $stmt->execute([$id]);
}

function calculateGradePoint($score) {
    if ($score >= 85) return 4.00;
    if ($score >= 70) return 3.00;
    if ($score >= 60) return 2.00;
    if ($score >= 50) return 1.00;
    return 0.00;
}
?>
