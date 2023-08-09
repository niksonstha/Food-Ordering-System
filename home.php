 <!-- Masthead-->

 <header class="masthead">
     <div class="container h-100">
         <div class="row h-100 align-items-center justify-content-center text-center">
             <div class="col-lg-10 align-self-center mb-4 page-title">
                 <h1 class="text-white">Welcome to <?php echo $_SESSION['setting_name']; ?></h1>
                 <hr class="divider my-4 bg-dark" />
                 <a class="btn btn-dark bg-black btn-xl js-scroll-trigger" href="#menu">Order Now</a>

             </div>

         </div>
     </div>
 </header>

 <section class="page-section" id="menu">
     <h1 class="text-center text-cursive" style="font-size:3em"><b>Menu</b></h1>
     <div class="d-flex justify-content-center">
         <hr class="border-dark" width="5%">
     </div>
     <div id="menu-field" class="card-deck mt-2">
         <?php
            include 'admin/db_connect.php';
            $limit = 10;
            $page = (isset($_GET['_page']) && $_GET['_page'] > 0) ? $_GET['_page'] - 1 : 0;
            $offset = $page > 0 ? $page * $limit : 0;
            $all_menu = $conn->query("SELECT id FROM  product_list")->num_rows;
            $page_btn_count = ceil($all_menu / $limit);
            $qry = $conn->query("SELECT * FROM  product_list order by `name` asc Limit $limit OFFSET $offset ");
            while ($row = $qry->fetch_assoc()) :
            ?>
             <div class="col-lg-3 mb-3">
                 <div class="card menu-item  rounded-0">
                     <div class="position-relative overflow-hidden" id="item-img-holder">
                         <img src="assets/img/<?php echo $row['img_path'] ?>" class="card-img-top" alt="...">
                     </div>
                     <div class="card-body rounded-0">
                         <h5 class="card-title"><?php echo $row['name'] ?></h5>
                         <p class="card-text truncate"><?php echo $row['description'] ?></p>
                         <div class="text-center">
                             <button class="btn btn-sm btn-outline-dark view_prod btn-block" data-id=<?php echo $row['id'] ?>><i class="fa fa-eye"></i> View</button>

                         </div>
                     </div>

                 </div>
             </div>
         <?php endwhile; ?>
     </div>
     <?php //$page_btn_count = 10;exit; 
        ?>
     <!-- Pagination Buttons Block -->
     <div class="w-100 mx-4 d-flex justify-content-center">
         <div class="btn-group paginate-btns">
             <!-- Previous Page Button -->
             <a class="btn btn-default border border-dark" <?php echo ($page == 0) ? 'disabled' : '' ?> href="./?_page=<?php echo ($page) ?>">Prev.</a>
             <!-- End of Previous Page Button -->
             <!-- Pages Page Button -->

             <!-- looping page buttons  -->
             <?php for ($i = 1; $i <= $page_btn_count; $i++) : ?>
                 <!-- Display button blocks  -->

                 <!-- Limiting Page Buttons  -->
                 <?php if ($page_btn_count > 10) : ?>
                     <!-- Show ellipisis button before the last Page Button  -->
                     <?php if ($i = $page_btn_count && !in_array($i, range(($page - 3), ($page + 3)))) : ?>
                         <a class="btn btn-default border border-dark ellipsis">...</a>
                     <?php endif; ?>

                     <!-- Show ellipisis button after the First Page Button  -->
                     <?php if ($i == 1 || $i == $page_btn_count || (in_array($i, range(($page - 3), ($page + 3))))) : ?>
                         <a class="btn btn-default border border-dark <?php echo ($i == ($page + 1)) ? 'active' : '';  ?>" href="./?_page=<?php echo $i ?>"><?php echo $i; ?></a>
                         <?php if ($i == 1 && !in_array($i, range(($page - 3), ($page + 3)))) : ?>
                             <a class="btn btn-default border border-dark ellipsis">...</a>
                         <?php endif; ?>
                     <?php endif; ?>
                 <?php else : ?>
                     <a class="btn btn-default border border-dark <?php echo ($i == ($page + 1)) ? 'active' : '';  ?>" href="./?_page=<?php echo $i ?>"><?php echo $i; ?></a>
                 <?php endif; ?>
                 <!-- Display button blocks  -->
             <?php endfor; ?>
             <!-- End of looping page buttons  -->

             <!-- End of Pages Page Button -->
             <!-- Next Page Button -->
             <a class="btn btn-default border border-dark" <?php echo (($page + 1) == $page_btn_count) ? 'disabled' : '' ?> href="./?_page=<?php echo ($page + 2) ?>">Next</a>
             <!-- End of Next Page Button -->
         </div>
     </div>
     <!-- End Pagination Buttons Block -->
     <section class="page-section" id="menu">
         <!-- Existing code for menu items -->
     </section>
     <style>
         /* Rest of your existing styles */

         #popular-menu .section-title {
             text-align: center;
             margin-bottom: 40px;
             font-size: 2em;
         }

         #popular-menu .menu-item {
             background-color: #f9f9f9;
             border: none;
             border-radius: 10px;
             padding: 20px;
             text-align: center;
             box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
             transition: transform 0.2s, box-shadow 0.2s;
             /* Increase width of the card */
             width: 250px;
         }

         #popular-menu .menu-item:hover {
             transform: translateY(-5px);
             box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
         }

         #popular-menu .menu-item .card-img-top {
             border-radius: 10px;
             object-fit: cover;
             /* Adjusted property */
             height: 180px;
             /* Decrease the width to fit the card */
             width: 100%;
         }

         #popular-menu .menu-item .card-title {
             font-size: 1.2em;
             font-weight: bold;
             margin-top: 10px;
         }

         #popular-menu .menu-item .card-text {
             font-size: 0.9em;
             color: #777;
             margin-top: 10px;
         }

         #popular-menu .menu-item .rating {
             display: flex;
             justify-content: center;
             margin-top: 10px;
             color: #FFD700;
         }

         #popular-menu .menu-item .rating i {
             font-size: 1.2em;
         }

         #popular-menu .menu-item .view_prod {
             background-color: #343a40;
             color: #ffffff;
             border-radius: 5px;
             padding: 8px 16px;
             font-size: 0.9em;
             transition: background-color 0.3s ease;
         }

         #popular-menu .menu-item .view_prod:hover {
             background-color: #212529;
         }

         #item-img-holders {
             height: 200px;
         }
     </style>

     <!-- ... Existing code ... -->

     <section id="popular-menu">
         <div class="container">
             <h2 class="section-title">Popular Food Items</h2>
             <div class="row">
                 <?php
                    include 'admin/db_connect.php';

                    // Query to get the top 4 popular food items based on highest average ratings
                    $query = "SELECT pl.*, AVG(pr.rating) AS avgerage_ratings
                      FROM product_list pl
                      LEFT JOIN product_ratings pr ON pl.id = pr.product_id
                      WHERE pr.rating IS NOT NULL
                      GROUP BY pl.id
                      HAVING avgerage_ratings > 0
                      ORDER BY avgerage_ratings DESC
                      LIMIT 4";

                    $popular_items_query = $conn->query($query);

                    if ($popular_items_query) {
                        while ($popular_item = $popular_items_query->fetch_assoc()) :
                    ?>
                         <div class="col-lg-3 col-md-6 mb-4">
                             <div class="card menu-item">
                                 <div class="position-relative overflow-hidden" id="item-img-holders">
                                     <img src="assets/img/<?php echo $popular_item['img_path'] ?>" class="card-img-top" alt="...">
                                 </div>
                                 <!-- ... existing code ... -->
                                 <div class="card-body">
                                     <h5 class="card-title"><?php echo $popular_item['name'] ?></h5>
                                     <p class="card-text truncate"><?php echo substr($popular_item['description'], 0, 100) . '...'; ?></p>
                                     <div class="rating">
                                         <?php
                                            $avg_rating = round($popular_item['avgerage_ratings'], 1);
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $avg_rating) {
                                                    echo '<i class="fas fa-star filled"></i>';
                                                } else {
                                                    echo '<i class="fas fa-star"></i>';
                                                }
                                            }
                                            ?>
                                     </div>
                                     <div class="text-center mt-3">
                                         <button class="btn btn-sm btn-dark view_prod btn-block" data-id="<?php echo $popular_item['id'] ?>"><i class="fa fa-eye"></i> View</button>
                                     </div>
                                 </div>

                             </div>
                         </div>
                 <?php
                        endwhile;
                    } else {
                        echo "Query Error: " . $conn->error;
                    }
                    ?>
             </div>
         </div>
     </section>

     <!-- ... Remaining code ... -->


 </section>
 <script>
     $('.view_prod').click(function() {
         uni_modal_right('Product Details', 'view_prod.php?id=' + $(this).attr('data-id'))
     })
 </script>
 <?php if (isset($_GET['_page'])) : ?>
     <script>
         $(function() {
             document.querySelector('html').scrollTop = $('#menu').offset().top - 100
         })
     </script>
 <?php endif; ?>