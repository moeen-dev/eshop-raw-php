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
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product Table</h4>
                            <a href="category-add.php" class="btn btn-primary">Add Product</a>
                            <!-- <p class="card-description"> Add class <code>.table-striped</code> -->
                            </p>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Product Image </th>
                                            <th> Product Name </th>
                                            <th> Product Category </th>
                                            <th> Product Price </th>
                                            <th> Product Status </th>
                                            <th> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        // $sql = "SELECT * FROM products ORDER BY id DESC";

                                        $sql = "SELECT products.*, categories.name AS category_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY products.id DESC";

                                        $query = $conn->query($sql);

                                        if ($query->num_rows > 0) {
                                            while ($product = $query->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td> <?php echo $count++; ?> </td>
                                                    <td class="py-1">
                                                        <img src="upload/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" />
                                                    </td>
                                                    <td> <?php echo $product['name']; ?> </td>
                                                    <td> <?php echo $product['category_name']; ?> </td>
                                                    <td>$ <?php echo $product['price']; ?> </td>
                                                    <td>
                                                        <?php
                                                        if ($product['status'] == 'in_stock') {
                                                            echo "<span class='badge badge-success'>Is Stock </span>";
                                                        } else {
                                                            echo "<span class='badge badge-danger'>Out of Stock </span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="d-flex gap-3">
                                                        <a href="product-edit.php?id=<?php echo $product['id']; ?>" class="btn btn-primary mr-2"> Edit</a>
                                                        <form action="controller/productcontroller.php" method="POST">
                                                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                            <button name="delete" class="btn btn-danger" onclick="return confirm('Do you want to delete it?') ">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
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
</body>

</html>