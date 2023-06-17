<?php

?>

<div class="container-fluid">

	<div class="row">
		<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New user</button>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Name</th>
							<th class="text-center">Email</th>
							<th class="text-center">Total Orders</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include 'db_connect.php';
						$users = $conn->query("SELECT *, count(order_list.user) as total_order FROM user_info 
                     join order_list on order_list.user=user_info.user_id
                      GROUP BY order_list.user ORDER BY user_info.first_name");
						$i = 1;
						while ($row = $users->fetch_assoc()) :
						?>
							<tr>
								<td>
									<?php echo $i++ ?>
								</td>
								<td>
									<?php echo $row['first_name'] ?>
								</td>
								<td>
									<?php echo $row['email'] ?>
								</td>
								<td>
									<?php echo $row['total_order'] ?>
								</td>
								<td>
									<center>
										<div class="btn-group">
											<button type="button" class="btn btn-primary">Action</button>
											<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['user_id'] ?>'>Edit</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['user_id'] ?>'>Delete</a>
											</div>
										</div>
									</center>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<script>
	$('#new_user').click(function() {
		uni_modal('New User', 'manage_customer.php')
	})
	$('.edit_user').click(function() {
		uni_modal('Edit User', 'manage_customer.php?id=' + $(this).attr('data-id'))
	})
</script>