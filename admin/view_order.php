<div class="container-fluid">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Qty</th>
				<th>Order</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = 0;
			include 'db_connect.php';
			$qry = $conn->query("SELECT * FROM order_list o INNER JOIN product_list p ON o.product_id = p.id WHERE order_id = " . $_GET['id']);
			while ($row = $qry->fetch_assoc()) :
				$total += $row['qty'] * $row['price'];
			?>
				<tr>
					<td><?php echo $row['qty'] ?></td>
					<td><?php echo $row['name'] ?></td>
					<td><?php echo number_format($row['qty'] * $row['price'], 2) ?></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2" class="text-right">TOTAL</th>
				<th><?php echo number_format($total, 2) ?></th>
			</tr>
		</tfoot>
	</table>

	<div class="form-group">
		<label for="tracking_value">Delivery Tracking:</label>
		<input type="text" class="form-control" id="tracking_value" name="tracking_value">
	</div>

	<div class="text-center">
		<button class="btn btn-primary" id="confirm" type="button" onclick="confirm_order()">Confirm</button>
		<button class="btn btn-success" id="update_tracking" type="button" onclick="update_tracking()">Update Tracking</button>
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	</div>
</div>

<script>
	function confirm_order() {
		start_load();
		$.ajax({
			url: 'ajax.php?action=confirm_order',
			method: 'POST',
			data: {
				id: '<?php echo $_GET['id'] ?>'
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Order confirmed.");
					setTimeout(function() {
						location.reload();
					}, 1500);
				}
			}
		});
	}

	function update_tracking() {
		var trackingValue = $('#tracking_value').val();
		if (trackingValue.trim() != '') {
			start_load();
			$.ajax({
				url: 'orders.php',
				method: 'POST',
				data: {
					update_tracking: true,
					order_id: '<?php echo $_GET['id'] ?>',
					tracking_value: trackingValue
				},
				success: function(resp) {
					alert_toast(resp);
					setTimeout(function() {
						location.reload();
					}, 1500);
				}
			});
		} else {
			alert('Please enter a delivery tracking value.');
		}
	}
</script>