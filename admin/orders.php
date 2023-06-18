<?php
// Include the database connection file (db_connect.php)
include 'db_connect.php';

// Function to sanitize input data
function sanitize($data)
{
	// Implement your sanitization logic here
	// This is just a basic example, you should customize it based on your specific requirements
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Handle the delivery tracking update
if (isset($_POST['update_tracking'])) {
	$order_id = $_POST['order_id'];
	$new_tracking_value = sanitize($_POST['tracking_value']);

	// Update the delivery_tracking value in the database
	$update_query = "UPDATE orders SET delivery_tracking = '$new_tracking_value' WHERE id = $order_id";
	if ($conn->query($update_query) === TRUE) {
		// Tracking value successfully updated
		echo "Delivery tracking value updated.";
	} else {
		// Error occurred while updating the tracking value
		echo "Error updating delivery tracking value: ";
	}
}

// Fetch orders from the database
$qry = $conn->query("SELECT * FROM orders");
?>

<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Address</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>Status</th>
						<th>Delivery Tracking</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					include 'db_connect.php';
					$qry = $conn->query("SELECT * FROM orders");
					while ($row = $qry->fetch_assoc()) :
						$deliveryTracking = $row['delivery_tracking']; // Retrieve delivery tracking information

						// Determine the delivery process text based on the presence of delivery tracking information
						// $deliveryProcess = !empty($deliveryTracking) ? 'In Transit' : 'Not Shipped';
						if (empty($deliveryTracking)) {
							$deliveryTracking = "Order placed";
						}
						// Check if the current order is the one being updated on the view_order.php page
						$isUpdatedOrder = isset($_POST['order_id']) && $_POST['order_id'] == $row['id'];
					?>
						<tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['address'] ?></td>
							<td><?php echo $row['email'] ?></td>
							<td><?php echo $row['mobile'] ?></td>
							<?php if ($row['status'] == 1) : ?>
								<td class="text-center"><span class="badge badge-success">Confirmed</span></td>
							<?php else : ?>
								<td class="text-center"><span class="badge badge-secondary">For Verification</span></td>
							<?php endif; ?>
							<td>
								<?php if ($isUpdatedOrder) : ?>
									<input type="text" class="form-control" id="delivery_tracking_<?php echo $row['id'] ?>" value="<?php echo $deliveryTracking ?>" disabled>
								<?php else : ?>
									<?php echo $deliveryTracking ?>
								<?php endif; ?>
							</td>
							<td>
								<button class="btn btn-sm btn-primary view_order" data-id="<?php echo $row['id'] ?>">View Order</button>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$('.view_order').click(function() {
		uni_modal('Order', 'view_order.php?id=' + $(this).attr('data-id'))
	})
</script>