<?php
session_start();
include 'admin/db_connect.php';

class RatingManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function submitRating($user_id, $order_id, $product_id, $rating)
    {
        // Check if the user has already rated this product in the order
        $check_query = $this->conn->query("SELECT id FROM product_ratings WHERE user_id = '$user_id' AND order_id = '$order_id' AND product_id = '$product_id'");
        if ($check_query->num_rows == 0) {
            // Insert the rating into the database
            $insert_query = $this->conn->query("INSERT INTO product_ratings (user_id, order_id, product_id, rating) VALUES ('$user_id', '$order_id', '$product_id', '$rating')");
            if ($insert_query) {
                // Calculate average ratings
                $averageRating = $this->calculateAverageRating($product_id);

                // Update the average_ratings column in product_list table
                $update_query = $this->conn->query("UPDATE product_list SET average_ratings = '$averageRating' WHERE id = '$product_id'");

                if ($update_query) {
                    $_SESSION['rating_submitted'] = true;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function calculateAverageRating($product_id)
    {
        // Retrieve ratings for the product
        $getRatings = $this->conn->query("SELECT rating FROM product_ratings WHERE product_id = '$product_id'");
        $ratings = [];
        while ($row = $getRatings->fetch_assoc()) {
            $ratings[] = $row['rating'];
        }

        // Calculate average rating
        $totalRatings = count($ratings);
        if ($totalRatings === 0) {
            return 0;
        }

        $sumRatings = array_sum($ratings);
        $averageRating = $sumRatings / $totalRatings;
        return round($averageRating, 2);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];

    $ratingManager = new RatingManager($conn);
    $result = $ratingManager->submitRating($user_id, $order_id, $product_id, $rating);

    if ($result) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'You have already rated this item.'));
    }
}
