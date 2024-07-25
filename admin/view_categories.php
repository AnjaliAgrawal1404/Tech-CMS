<?php
// Include database configuration file for database connection
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if user is not logged in
    header("Location: .././login.php ");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Category</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <?php include 'includes/header.php'; // Include header ?>
</head>
<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; // Include sidebar ?>
        <!-- Content -->
        <main class="s-layout__content p-0 ">
            <div class="container">
                <!-- Button to add a new category -->
                <div>
                    <a href="add_category.php">
                        <button class="btn btn-primary ml-5" style="float:right;">Add Category</button>
                    </a>
                </div>

                <!-- Header wrap with filters and search -->
                <div class="header_wrap">
                    <div class="num_rows">
                        <div class="form-group">
                            <!-- Dropdown to select number of rows to display -->
                            <select class="form-control" name="state" id="maxRows">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="70">70</option>
                                <option value="100">100</option>
                                <option value="5000">Show ALL Rows</option>
                            </select>
                        </div>
                    </div>
                    <div class="tb_search">
                        <!-- Search input for filtering categories -->
                        <input type="text" id="search_input_all" onkeyup="FilterkeyWord_all_table()" placeholder="Search.." class="form-control">
                    </div>
                </div>

                <!-- Table to display categories -->
                <table class="table table-striped table-class" id="table-id">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // SQL query to fetch categories from the database
                        $sql = "SELECT * FROM category WHERE deleted_at = '0000-00-00 00:00:00'";
                        $result = mysqli_query($conn, $sql);

                        // Check if any categories are returned
                        if (!empty($result)) {
                            while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <!-- Display category name -->
                                    <td><?php echo $data['category_name']; ?></td>
                                    <!-- Actions: Edit and Delete -->
                                    <td>
                                        <a href="update_categories.php?id=<?php echo $data['category_id'] ?>" class="edit pr-2"><i class="fas fa-edit"></i></a>
                                        <a href="delete_category.php?id=<?php echo $data['category_id'] ?>" class="delete"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            // Display message if no categories are found
                            echo '<tr><td colspan="2">No Categories are found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Start Pagination -->
                <div class='pagination-container'>
                    <nav>
                        <ul class="pagination pb-5">
                            <!-- Pagination links will be added by JavaScript -->
                        </ul>
                    </nav>
                </div>
                <!-- Row count display -->
                <div class="rows_count">Showing 11 to 20 of 91 entries</div>

            </div> <!-- End of Container -->

        </main>
    </div>
    <!-- Include custom JavaScript -->
    <script src="js/myscript.js"></script>
</body>

</html>
