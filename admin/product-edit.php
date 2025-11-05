<?php
include_once 'controller/db.php';
include_once 'partials/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once 'partials/head.php';
?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <?php
        include_once 'partials/sidebar.php';
        ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <?php
            include_once 'partials/navbar.php';
            ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Basic form elements</h4>
                                    <p class="card-description"> Basic form elements </p>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        $id = $_GET['id'];

                                        // Fetch product by ID
                                        $productSql = "SELECT * FROM products WHERE id = $id";
                                        $productQuery = $conn->query($productSql);

                                        if ($productQuery && $productQuery->num_rows > 0) {
                                            $product = $productQuery->fetch_assoc();

                                            // Fetch categories
                                            $categoriesSql = "SELECT id, name FROM categories";
                                            $categoriesQuery = $conn->query($categoriesSql);
                                    ?>
                                            <form class="forms-sample" action="controller/productcontroller.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                                                <div class="form-group">
                                                    <label for="productName">Product Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="productName" class="form-control" id="productName"
                                                        placeholder="Product Name" value="<?php echo htmlspecialchars($product['name']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="categoryName">Category Name</label>
                                                    <select name="productCategory" id="productCategory" class="form-control">
                                                        <option disabled>--Select Product Category--</option>
                                                        <?php
                                                        if ($categoriesQuery->num_rows > 0) {
                                                            while ($category = $categoriesQuery->fetch_assoc()) {
                                                                $selected = ($category['id'] == $product['category_id']) ? 'selected' : '';
                                                        ?>
                                                                <option value="<?php echo $category['id']; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $category['name']; ?>
                                                                </option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="productImage">Category Image</label>
                                                    <input type="file" name="productImage" class="dropify" data-default-file="upload/<?php echo $product['image']; ?>" id="categoryImage">
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="price">Price <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="price" id="price"
                                                                placeholder="Enter product price"
                                                                value="<?php echo htmlspecialchars($product['price']); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">Status <span class="text-danger">*</span></label>
                                                            <select name="status" id="status" class="form-control">
                                                                <option disabled>--Please select an option--</option>
                                                                <option value="in_stock" <?php if ($product['status'] == 'in_stock') echo 'selected'; ?>>In Stock</option>
                                                                <option value="out_stock" <?php if ($product['status'] == 'out_stock') echo 'selected'; ?>>Out of Stock</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Product Description (Optional)</label>
                                                    <textarea name="description" id="description" class="form-control" rows="10"><?php echo htmlspecialchars($product['description']); ?></textarea>
                                                </div>

                                                <button type="submit" name="update" class="btn btn-primary mr-2">Update</button>
                                                <button type="button" class="btn btn-dark" onclick="window.location.href='category-list.php'">Cancel</button>
                                            </form>
                                    <?php
                                        } else {
                                            echo "<p class='text-danger'>No Data Found!</p>";
                                        }
                                    } else {
                                        echo "<p class='text-danger'>No Product ID Provided!</p>";
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <?php
                include_once 'partials/footer.php';
                ?>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <?php
    include_once 'partials/script.php';
    ?>
    <!-- End custom js for this page -->
</body>

</html>