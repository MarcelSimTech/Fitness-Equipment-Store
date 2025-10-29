<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];
$change = $data['change'];
$user_id = $_SESSION['user_id'];

if ($change > 0) {
  $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
} else {
  $sql = "UPDATE cart SET quantity = quantity - 1 WHERE user_id = ? AND product_id = ?";
}
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

// Remove if quantity becomes 0 or less
$conn->query("DELETE FROM cart WHERE quantity <= 0");

echo json_encode(['status' => 'updated']);
?>
