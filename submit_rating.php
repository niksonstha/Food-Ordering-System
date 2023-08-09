<?php
session_start();
include 'admin/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];

    // Check if the user has already rated this product in the order
    $check_query = $conn->query("SELECT id FROM product_ratings WHERE user_id = '$user_id' AND order_id = '$order_id' AND product_id = '$product_id'");
    if ($check_query->num_rows == 0) {
        // Insert the rating into the database
        $insert_query = $conn->query("INSERT INTO product_ratings (user_id, order_id, product_id, rating) VALUES ('$user_id', '$order_id', '$product_id', '$rating')");
        if ($insert_query) {
            // Calculate and update the average_ratings in product_list table
            $update_query = $conn->query("UPDATE product_list SET average_ratings = ROUND((SELECT AVG(rating) FROM product_ratings WHERE product_id = '$product_id'), 2) WHERE id = '$product_id'");
            if ($update_query) {
                $_SESSION['rating_submitted'] = true;
                echo json_encode(array('status' => 'success'));
                exit;
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Error updating average ratings'));
                exit;
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error submitting rating'));
            exit;
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'You have already rated this product for this order.'));
    }
}
