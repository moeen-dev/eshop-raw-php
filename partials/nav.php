<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="index.php"><img src="assets/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <?php $page = basename($_SERVER['PHP_SELF']); ?>
                        <li class="<?php if ($page == 'index.php') echo 'active'; ?>"><a href="index.php">Home</a></li>
                        <li class="<?php if ($page == 'category-product.php') echo 'active'; ?>"><a href="category-product.php">Category</a></li>
                        <li class="<?php if ($page == 'shop-page.php') echo 'active'; ?>"><a href="shop-page.php">Shop</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="cart-product.php"><i class="fa fa-shopping-bag"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>