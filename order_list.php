<!-- Masthead -->
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

<?php
echo $_SESSION['login_user_id'];
?>
<style>
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
</style>

<section class="page-section" id="menu">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="sticky">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4"><b>Items</b></div>
                                <div class="col-md-4"><b>Total</b></div>
                                <div class="col-md-4 text-right"><b>Status</b></div>
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
                                <div class="col-md-4 order-status">

                                    <?php
                                    $i = 1;
                                    include 'admin/db_connect.php';
                                    $qry = $conn->query("SELECT * FROM orders WHERE id = " . $row['order_id']);
                                    while ($order = $qry->fetch_assoc()) :
                                        if ($order['status'] == 1) :
                                    ?>
                                            <p class="text-success"><b>Confirmed</b></p>
                                        <?php else : ?>
                                            <p class="text-secondary"><b>For Verification</b></p>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
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
</section>

<style>
    /* CSS styles */
</style>