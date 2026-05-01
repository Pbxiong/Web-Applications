<?php
require_once "db.php";
header("Content-Type: application/json");

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data || !isset($data["id"]) || trim($data["id"]) === "") {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Missing holding id"
    ]);
    exit;
}

$id = trim($data["id"]);

$stmt = $conn->prepare("DELETE FROM portfolio_holdings WHERE id = ?");

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("s", $id);
$stmt->execute();

echo json_encode([
    "success" => true,
    "deleted_id" => $id,
    "affected_rows" => $stmt->affected_rows
]);

$stmt->close();
$conn->close();
?>
