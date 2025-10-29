<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

echo json_encode(['status' => 'removed']);
?>
