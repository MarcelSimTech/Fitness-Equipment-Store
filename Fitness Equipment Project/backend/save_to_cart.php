<?php
session_start();
include 'db.php'; // connect to your DB

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
  exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

$product_id = $data['id'];
$product_name = $data['name'];
$price = $data['price'];
$quantity = $data['quantity'];
$image = $data['image'];

$sql = "SELECT * FROM cart WHERE user_id=? AND product_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $sql = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iii", $quantity, $user_id, $product_id);
} else {
  $sql = "INSERT INTO cart (user_id, product_id, product_name, price, quantity, image)
          VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iisdis", $user_id, $product_id, $product_name, $price, $quantity, $image);
}

if ($stmt->execute()) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
?>
