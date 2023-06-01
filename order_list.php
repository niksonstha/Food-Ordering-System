 <!-- Masthead-->
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
 <section class="page-section" id="menu">
     <div class="container">
         <div class="row">
             <div class="col-lg-8">
                 <div class="sticky">
                     <div class="card">
                         <div class="card-body">
                             <div class="row">
                                 <div class="col-md-8"><b>Items</b></div>
                                 <div class="col-md-4 text-right"><b>Total</b></div>
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
                        $total += ($row['qty'] * $row['price']);
                    ?>

                     <div class="card">
                         <div class="card-body">
                             <div class="row">
                                 <div class="col-md-4 d-flex align-items-center" style="text-align: -webkit-center">
                                     <div class="col-auto flex-shrink-1 flex-grow-1 text-center">
                                         <img src="assets/img/<?php echo $row['img_path'] ?>" alt="">
                                     </div>
                                 </div>
                                 <div class="col-md-4">
                                     <p><b>
                                             <large><?php echo $row['name'] ?></large>
                                         </b></p>
                                     <p class='truncate'> <b><small>Desc :<?php echo $row['description'] ?></small></b></p>
                                     <p> <b><small>Unit Price :<?php echo number_format($row['price'], 2) ?></small></b></p>
                                     <p><small>QTY :</small></p>
                                 </div>
                                 <div class="col-md-4 text-right">
                                     <b>
                                         <large><?php echo number_format($row['qty'] * $row['price'], 2) ?></large>
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
                     <div class="col-md-6">
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
     .card p {
         margin: unset
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
         background: white
     }

     .rem_cart {
         position: absolute;
         left: 0;
     }
 </style>
 <script>
     $('.view_prod').click(function() {
         uni_modal_right('Product', 'view_prod.php?id=' + $(this).attr('data-id'))
     })
     $('.qty-minus').click(function() {
         var qty = $(this).parent().siblings('input[name="qty"]').val();
         update_qty(parseInt(qty) - 1, $(this).attr('data-id'))
         if (qty == 1) {
             return false;
         } else {
             $(this).parent().siblings('input[name="qty"]').val(parseInt(qty) - 1);
         }
     })
     $('.qty-plus').click(function() {
         var qty = $(this).parent().siblings('input[name="qty"]').val();
         $(this).parent().siblings('input[name="qty"]').val(parseInt(qty) + 1);
         update_qty(parseInt(qty) + 1, $(this).attr('data-id'))
     })

     function update_qty(qty, id) {
         start_load()
         $.ajax({
             url: 'admin/ajax.php?action=update_cart_qty',
             method: "POST",
             data: {
                 id: id,
                 qty
             },
             success: function(resp) {
                 if (resp == 1) {
                     load_cart()
                     end_load()
                 }
             }
         })

     }
     $('#checkout').click(function() {
         if ('<?php echo isset($_SESSION['login_user_id']) ?>' == 1) {
             location.replace("index.php?page=checkout")
         } else {
             uni_modal("Checkout", "login.php?page=checkout")
         }
     })
 </script>