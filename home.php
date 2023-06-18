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
         /* Popular Menu Items Section */
         /* Popular Menu Items Section */
         #popular-menu {
             background-color: #f8f9fa;
             padding: 80px 0;
             display: flex;
             flex-wrap: wrap;
             flex-direction: column;
             justify-content: center;
             align-items: center;
             overflow-x: hidden;
         }

         #popular-menu .section-title {
             text-align: center;
             margin-bottom: 60px;
         }

         #popular-menu .menu-item {
             background-color: #ffffff;
             border: 1px solid #dee2e6;
             border-radius: 0;
             padding: 20px;
             text-align: center;
             margin: 20px;
             display: flex;
             flex-direction: column;
             justify-content: center;
             align-items: center;
         }

         #popular-menu .menu-item img {
             width: 100%;
             height: 100%;
             border-radius: 5px;
             object-fit: cover;
         }

         /* Rest of the CSS styles */


         #popular-menu .menu-item h5 {
             font-size: 20px;
             font-weight: bold;
             margin-bottom: 10px;
         }

         #popular-menu .menu-item p {
             font-size: 16px;
             color: #777777;
             margin-bottom: 20px;
         }

         #popular-menu .menu-item .view_prod {
             background-color: #343a40;
             color: #ffffff;
             border-radius: 20px;
             padding: 10px 20px;
             font-size: 14px;
             transition: background-color 0.3s ease;
         }

         #popular-menu .menu-item .view_prod:hover {
             background-color: #212529;
         }

         @media (max-width: 767.98px) {
             #popular-menu .section-title {
                 margin-bottom: 30px;
             }

             #popular-menu .menu-item {
                 padding: 15px;
             }

             #popular-menu .menu-item img {
                 margin-bottom: 15px;
             }

             #popular-menu .menu-item h5 {
                 font-size: 18px;
             }

             #popular-menu .menu-item p {
                 font-size: 14px;
                 margin-bottom: 15px;
             }
         }
     </style>
     <div id="popular-menu" class="section">
         <div class="row">
             <div class="col-lg-12">
                 <h2>Popular Menu Items</h2>
                 <hr class="divider">
             </div>
         </div>
         <div class="row ">
             <?php
                include 'admin/db_connect.php';

                // Fetch the four most popular menu items
                $query = "SELECT p.id, p.name, p.description, p.img_path, COUNT(o.order_id) as total_orders 
                  FROM product_list p 
                  INNER JOIN order_list o ON o.product_id = p.id
                  GROUP BY p.id
                  ORDER BY total_orders DESC
                  LIMIT 4";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-lg-3 mb-3">';
                        echo '<div class="card menu-item rounded-0">';
                        echo '<div class="position-relative overflow-hidden" id="item-img-holder">';
                        echo '<img src="assets/img/' . $row['img_path'] . '" class="card-img-top" alt="...">';
                        echo '</div>';
                        echo '<div class="card-body rounded-0">';
                        echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                        echo '<p class="card-text truncate">' . $row['description'] . '</p>';
                        echo '<div class="text-center">';
                        echo '<button class="btn btn-sm btn-outline-dark view_prod btn-block" data-id="' . $row['id'] . '"><i class="fa fa-eye"></i> View</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-lg-12 text-center">No popular menu items found.</div>';
                }

                $conn->close();
                ?>
         </div>
     </div>
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