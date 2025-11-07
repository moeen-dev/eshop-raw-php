<?php
include_once 'controller/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once 'partials/head.php';
?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="assets/img/logo.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img src="assets/img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div>
            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i> Login</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.html">Home</a></li>
                <li><a href="./shop-grid.html">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.html">Shop Details</a></li>
                        <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                        <li><a href="./checkout.html">Check Out</a></li>
                        <li><a href="./blog-details.html">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.html">Blog</a></li>
                <li><a href="./contact.html">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php
    include_once 'partials/nav.php';
    ?>
    <!-- Header Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="assets/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Organi Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="incex.php">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <?php
                        if (isset($_GET['category_id'])) {
                            $category_id = intval($_GET['category_id']);
                            $sql = "SELECT * FROM products WHERE category_id = $category_id";
                        } else {
                            $sql = "SELECT * FROM products";
                        }

                        $query = $conn->query($sql);

                        if ($query->num_rows > 0) {
                            while ($product = $query->fetch_assoc()) {
                        ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                                    <div class="featured__item">
                                        <div class="featured__item__pic set-bg" data-setbg="admin/upload/<?php echo $product['image']; ?>">
                                            <ul class="featured__item__pic__hover">
                                                <li>
                                                    <form action="controller/cart.php" method="POST">
                                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                        <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                                                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                                        <input type="hidden" name="image" value="<?php echo $product['image']; ?>">
                                                        <input type="hidden" name="quantity" value="1">

                                                        <!-- button with icon -->
                                                        <button type="submit" name="add_to_cart" style="border:none; background:none; cursor:pointer;">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="featured__item__text">
                                            <h6><a href="product-details.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h6>
                                            <h5>$<?php echo $product['price'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "No Product Found";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="assets/img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="assets/img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Footer Section Begin -->
    <?php
    include_once 'partials/footer.php';
    ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/jquery.slicknav.js"></script>
    <script src="assets/js/mixitup.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/main.js"></script>



</body>

</html>