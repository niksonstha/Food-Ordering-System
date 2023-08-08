<!-- Masthead -->
<?php
include 'admin/db_connect.php';

?>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <h1 class="text-white">Your Orders</h1>
                <hr class="divider my-4 bg-dark" />
            </div>
        </div>
    </div>
</header>



<style>
    .page-section {
        max-width: 100%;
    }

    .card p {
        margin: unset;
    }

    .card img {
        max-width: calc(100%);
        max-height: calc(59%);
    }

    div.sticky {
        position: -webkit-sticky;
        /* Safari */
        position: sticky;
        top: 4.7em;
        z-index: 10;
        background: white;
    }

    .rem_cart {
        position: absolute;
        left: 0;
    }

    /* Updated styles for order list */
    .card-body {
        padding: 20px;
    }

    .order-item {
        margin-bottom: 20px;
    }

    .order-item .order-image {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .order-item .order-image img {
        max-width: 100%;
        max-height: 120px;
        object-fit: contain;
    }

    .order-item .order-details {
        padding-left: 20px;
    }

    .order-item .order-details p {
        margin-bottom: 5px;
    }

    .order-item .order-status {
        text-align: right;
    }

    .order-item .order-status p {
        margin-bottom: 0;
    }

    .order-item .order-total {
        text-align: right;
        margin-top: 10px;
    }

    .order-item .order-total p {
        margin-bottom: 5px;
    }

    .page-section .container {
        max-width: 1200px;
        /* Set your desired width here */
    }
</style>
<section class="page-section" id="menu">
    <div class="container">
        <div class="row">
            <div class="col-lg-20">
                <div class="sticky">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4"><b>Items</b></div>
                                <div class="col-md-4"><b>Total</b></div>
                                <div class="col-md-2 text-right"><b>Status</b></div>
                                <div class="col-md-2 text-right"><b>Delivery Tracking</b></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_SESSION['login_user_id'])) {
                    $data = "where c.user_id = '" . $_SESSION['login_user_id'] . "' ";
                } else {
                    $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
                    $data = "where c.client_ip = '" . $ip . "' ";
                }
                $total = 0;

                $get = $conn->query("SELECT *
                    FROM user_info ui
                    JOIN order_list ol ON ui.user_id = ol.user
                    JOIN product_list pl ON ol.product_id = pl.id where ui.user_id=" . $_SESSION['login_user_id']);
                while ($row = $get->fetch_assoc()) :
                    $subtotal = $row['qty'] * $row['price'];
                    $total += $subtotal;
                ?>

                    <div class="card order-item">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 order-image">
                                    <div class="col-auto flex-shrink-1 flex-grow-1 text-center">
                                        <img src="assets/img/<?php echo $row['img_path'] ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4 order-details">
                                    <p><b>
                                            <large><?php echo $row['name'] ?></large>
                                        </b></p>
                                    <p class="truncate"><b><small>Desc: <?php echo $row['description'] ?></small></b></p>
                                    <p><b><small>Unit Price: <?php echo number_format($row['price'], 2) ?></small></b></p>
                                    <p><small>QTY: <?php echo $row['qty'] ?></small></p>
                                </div>
                                <div class="col-md-2 order-status ">
                                    <?php
                                    $i = 1;
                                    include 'admin/db_connect.php';
                                    $qry = $conn->query("SELECT * FROM orders WHERE id = " . $row['order_id']);
                                    while ($order = $qry->fetch_assoc()) :
                                        if ($order['status'] == 1) :
                                    ?>
                                            <p class="text-success"><b>Confirmed</b></p>
                                        <?php else : ?>
                                            <p class="text-secondary" style="white-space: nowrap;"><b>For Verification</b></p>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </div>
                                <div class=" col-md-2 order-delivery">
                                    <?php
                                    include 'admin/db_connect.php';
                                    $order_id = $row['order_id'];
                                    $qry = $conn->query("SELECT delivery_tracking FROM orders WHERE id = $order_id");
                                    if ($qry->num_rows > 0) {
                                        $order = $qry->fetch_assoc();
                                        $delivery_tracking = $order['delivery_tracking'];
                                        echo $delivery_tracking;
                                    }
                                    ?>
                                </div>
                                <div class="col-md-2 text-right">
                                    <b>Give Ratings</b>
                                    <form action="submit_rating.php" method="post" class="submit-rating-form">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                        <select name="rating" class="form-control">
                                            <option value="5">5 Stars</option>
                                            <option value="4">4 Stars</option>
                                            <option value="3">3 Stars</option>
                                            <option value="2">2 Stars</option>
                                            <option value="1">1 Star</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary mt-2">Submit Rating</button>
                                    </form>
                                </div>

                                <div class="col-md-4 text-right">
                                    <b>
                                        <large><?php echo number_format($subtotal, 2) ?></large>
                                    </b>
                                </div>
                            </div>
                        </div>


                    </div>



                <?php endwhile; ?>


                <div class="row">
                    <div class="col-md-6">
                        <hr>
                        <p>
                            <large>Total Ordered Amount</large>
                        </p>
                        <hr>
                    </div>
                    <div class="col-md-6 order-total">
                        <hr>
                        <p class="text-right"><b><?php echo number_format($total, 2) ?></b></p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="toast-container" class="position-fixed top-0 end-0 p-3"></div>

</section>


<script>
    $(document).ready(function() {
        $('.submit-rating-form').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        showToast('Rating submitted successfully.');
                    } else {
                        showToast('Error submitting rating.');
                    }
                },
                error: function() {
                    showToast('You have already rated this product for this order.');
                }
            });
        });

        function showToast(message) {
            var toast = $('<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: fixed; top: 20px; right: 20px;">' +
                '<div class="toast-header">' +
                '<strong class="mr-auto">Rating Submitted</strong>' +
                '<small class="text-muted">Just now</small>' +
                '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<div class="toast-body">' +
                message +
                '</div>' +
                '</div>');

            $('#toast-container').append(toast);

            toast.toast('show');
        }
    });
</script>