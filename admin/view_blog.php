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
    <title>View Blogs</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/index.css">
    <?php include 'includes/header.php'; // Include header ?>
</head>
<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; // Include sidebar ?>
        <!-- Content -->
        <main class="s-layout__content p-0 ">
            <div class="container">
                <!-- Button to add a new blog -->
                <div>
                    <a href="add_blog.php">
                        <button class="btn btn-primary ml-5" style="float:right;">Add Blog</button>
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
                        <!-- Search input for filtering blogs -->
                        <input type="text" id="search_input_all" onkeyup="FilterkeyWord_all_table()" placeholder="Search.." class="form-control">
                    </div>
                </div>

                <!-- Table to display blogs -->
                <table class="table table-striped table-class" id="table-id">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Name</th>
                            <th>Posted By</th>  
                            <th>Date</th>
                            <th>Published Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // SQL query to fetch blogs from the database
                        $sql = "SELECT * FROM blog WHERE deleted_at = '0000-00-00 00:00:00'";
                        $result = mysqli_query($conn, $sql);

                        // Check if any blogs are returned
                        if (!empty($result)) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                // Fetch category name
                                $get_category_name = "SELECT category_name FROM category WHERE category_id = '{$data['category_id']}'";
                                $category = mysqli_query($conn, $get_category_name);
                                $category_name = mysqli_fetch_assoc($category);

                                // Fetch user details
                                $get_user_name = "SELECT full_name, role FROM user WHERE user_id = '{$data['user_id']}'";
                                $user = mysqli_query($conn, $get_user_name);
                                $user_name_role = mysqli_fetch_assoc($user);

                                // Wordwrap description for better readability
                                $wrapped_description = wordwrap($data['blog_description'], 95, "<br />\n");
                    ?>
                        <tr>
                            <!-- Display blog image -->
                            <td><img class="" width="60px" height="60px" src=".././../uploads/<?php echo $data['blog_image']; ?>" alt=""></td>
                            <!-- Display category name -->
                            <td><?php echo $category_name['category_name'] ?></td>
                            <!-- Display blog title -->
                            <td><?php echo $data['blog_title'] ?></td>
                            <!-- Display wrapped blog description -->
                            <td><?php echo $wrapped_description ?></td>
                            <!-- Display author's full name -->
                            <td><?php echo $user_name_role['full_name'] ?></td>
                            <!-- Display author's role -->
                            <td><?php echo $user_name_role['role'] ?></td>
                            <!-- Display formatted date -->
                            <td><?php
                                $timestamp = strtotime($data['created_at']);
                                $formattedDate = date('d F Y', $timestamp);
                                echo $formattedDate ?></td>
                            <!-- Toggle publish status -->
                            <td>
                                <?php if ($data['published_status'] == 0) { ?>
                                    <div class="toggle-button" onclick="togglePublish(this, <?php echo $data['blog_id']; ?>)">
                                        <span class="status-text">Unpublished</span>
                                    </div>
                                <?php } else { ?>
                                    <div class="toggle-button active" onclick="togglePublish(this, <?php echo $data['blog_id']; ?>)">
                                        <span class="status-text">Published</span>
                                    </div>
                                <?php } ?>
                            </td>
                            <!-- Actions: Edit and Delete -->
                            <td>
                                <a href="update_blog.php?id=<?php echo $data['blog_id'] ?>" class="edit pr-2"><i class="fas fa-edit"></i></a>
                                <a href="delete_blog.php?id=<?php echo $data['blog_id'] ?>" class="delete"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php 
                            }
                        } else {
                            // Display message if no blogs are found
                            echo '<tr><td colspan="9">No Blogs are found.</td></tr>';
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
                <!-- Row count display -->
                <div class="rows_count">Showing 11 to 20 of 91 entries</div>

            </div> <!-- End of Container -->

        </main>
    </div>

    <!-- JavaScript for toggling publish status -->
    <script>
        function togglePublish(button, postId) {
            // Toggle active class on button
            button.classList.toggle('active');

            // Determine publish status based on the active class
            var status = button.classList.contains('active') ? 1 : 0;

            // Update status text and button background color based on status
            var statusText = button.querySelector('.status-text');
            if (status === 1) {
                statusText.textContent = 'Published';
                button.style.backgroundColor = '#4CAF50'; // Green for published
            } else {
                statusText.textContent = 'Unpublished';
                button.style.backgroundColor = '#ccc'; // Gray for unpublished
            }

            // Send AJAX request to update publish status in the database
            updatePublishStatus(postId, status);
        }

        function updatePublishStatus(postId, status) {
            // Create AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'publish.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Success - log response from server
                    console.log(xhr.responseText);
                } else {
                    // Server error
                    console.error('Server error: ' + xhr.status);
                }
            };
            xhr.onerror = function () {
                // Request failed
                console.error('Request failed');
            };
            xhr.send('postId=' + postId + '&status=' + status);
        }
    </script>

    <!-- Include custom JavaScript -->
    <script src="js/myscript.js"></script>
</body>

</html>
