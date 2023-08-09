<?php
include 'admin/db_connect.php';

// Calculate average ratings for each product
$productIds = [];
$averageRatings = [];

$getRatings = $conn->query("SELECT product_id, AVG(rating) AS average_rating FROM product_ratings GROUP BY product_id");
while ($row = $getRatings->fetch_assoc()) {
    $productIds[] = $row['product_id'];
    $averageRatings[$row['product_id']] = $row['average_rating'];
}

// Update the average_ratings column in product_list table
foreach ($productIds as $productId) {
    $averageRating = isset($averageRatings[$productId]) ? $averageRatings[$productId] : 0;
    $updateQuery = $conn->query("UPDATE product_list SET average_ratings = $averageRating WHERE id = $productId");
}

echo "Average ratings updated successfully.";
?>
