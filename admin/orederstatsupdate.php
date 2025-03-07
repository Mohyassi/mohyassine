<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['status']) && isset($_POST['id'])) {
        $status = mysqli_real_escape_string($con, $_POST['status']);
        $id = (int)$_POST['id']; // Cast to integer for extra security

        $update = mysqli_query($con, "UPDATE orders SET status = '$status' WHERE order_id = $id");

        if ($update) {
            echo json_encode(['success' => true, 'message' => 'Order status updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating order status: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing status or order ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>