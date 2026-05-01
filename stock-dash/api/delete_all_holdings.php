<?php
require_once "db.php";
header("Content-Type: application/json");

$sql = "DELETE FROM portfolio_holdings";

if ($conn->query($sql)) {
    echo json_encode([
        "success" => true,
        "message" => "All holdings deleted",
        "affected_rows" => $conn->affected_rows
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Delete all failed: " . $conn->error
    ]);
}

$conn->close();
?>
