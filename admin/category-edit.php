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

                                        $sql = "SELECT * FROM categories WHERE id = $id";
                                        $query = $conn->query($sql);

                                        if ($query->num_rows > 0) {
                                            while ($category = $query->fetch_assoc()) {
                                    ?>
                                                <form class="forms-sample" action="controller/categorycontroller.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                                    <div class="form-group">
                                                        <label for="categoryName">Category Name</label>
                                                        <input type="text" name="categoryName" class="form-control" value="<?php echo $category['name']; ?>" id="categoryName" placeholder="Category Name" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="categoryImage">Category Image</label>
                                                        <input type="file" name="categoryImage" class="dropify" data-default-file="upload/<?php echo $category['image']; ?>" id="categoryImage">
                                                    </div>
                                                    <button type="submit" name="update" class="btn btn-primary mr-2">Update</button>
                                                    <button class="btn btn-dark" name="cancel" onclick="window.location.href='category-list.php'">Cancel</button>
                                                </form>
                                    <?php
                                            }
                                        }
                                    } else {
                                        echo "No Data Found!";
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