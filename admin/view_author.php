<?php
// Include database configuration file
include 'includes/db_config.php';

// Check if user is logged in
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
    <title>View Author</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <?php
    // Include the header
    include 'includes/header.php';
    ?>
</head>

<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php
        // Include the sidebar
        include 'includes/sidebar.php';
        ?>
        <!-- Content -->
        <main class="s-layout__content p-0">
            <div class="container">

                <!-- Header with controls -->
                <div class="header_wrap">
                    <!-- Rows per page selection -->
                    <div class="num_rows">
                        <div class="form-group">
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

                    <!-- Search input -->
                    <div class="tb_search">
                        <input type="text" id="search_input_all" onkeyup="FilterkeyWord_all_table()" placeholder="Search.." class="form-control">
                    </div>
                </div>

                <!-- Authors table -->
                <table class="table table-striped table-class" id="table-id">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Fetch authors from the database
                        $sql = "SELECT * FROM user WHERE deleted_at = '0000-00-00 00:00:00' AND role='Author'";
                        $result = mysqli_query($conn, $sql);

                        // Check if any authors are found
                        if (!empty($result)) {
                            while ($data = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <!-- Author's profile image -->
                            <td><img width="60px" class="rounded-circle" height="60px" src=".././../uploads/<?php echo $data['profile']; ?>" alt=""></td>
                            <!-- Author's full name -->
                            <td><?php echo $data['full_name']; ?></td>
                            <!-- Author's email -->
                            <td><?php echo $data['email']; ?></td>
                            <!-- Action: delete link -->
                            <td>
                                <a href="delete_author.php?id=<?php echo $data['user_id'];?>" class="delete"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php 
                            }
                        } else {
                            // Display message if no authors are found
                            echo '<tr><td colspan="4">No Authors are found.</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class='pagination-container'>
                    <nav>
                        <ul class="pagination pb-5">
                            <!-- Pagination links will be added by JavaScript -->
                        </ul>
                    </nav>
                </div>
                <!-- Rows count -->
                <div class="rows_count">Showing 11 to 20 of 91 entries</div>

            </div> <!-- End of Container -->

        </main>
    </div>
    <!-- Include custom JavaScript -->
    <script src="js/myscript.js"></script>
</body>

</html>
