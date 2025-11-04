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
                                    
                                    <form class="forms-sample" action="controller/productcontroller.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="productName">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" name="productName" class="form-control" id="productName" placeholder="Product Name" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="categoryName">Category Name</label>
                                            <select name="productCategory" id="productCategory" class="form-control" required>
                                                <option selected disabled>--Select Product Category--</option>
                                                <?php
                                                $sql = "SELECT id, name FROM categories";
                                                $query = $conn->query($sql);

                                                if ($query->num_rows > 0) {
                                                    while ($category = $query->fetch_assoc()) {
                                                ?>
                                                        <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="productImage">Product Image</label>
                                            <input type="file" name="productImage" class="dropify" id="productImage" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="price">Price <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="price" id="price" placeholder="Enter product price" required autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status">Status <span class="text-danger">*</span></label>
                                                    <select name="status" id="status" class="form-control">
                                                        <option selected disabled>--Please select an option--</option>
                                                        <option value="in_stock">In Stock</option>
                                                        <option value="out_stock">Out of Stock</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Product Description (Optional)</label>
                                            <textarea name="description" id="description" class="form-control" rows="10"></textarea>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                        <button class="btn btn-dark" name="cancel" onclick="window.location.href='category-list.php'">Cancel</button>
                                    </form>
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