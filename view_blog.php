<?php
include 'includes/db_config.php'; // Include the database configuration file

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:login.php"); // Redirect to login page if not logged in
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
    <?php include 'includes/header.php'; // Include the header file ?>
</head>
<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; // Include the sidebar file ?>
        <!-- Content -->
        <main class="s-layout__content p-0 ">
            <div class="container">
                <div>
                    <a href="add_blog.php">
                        <button class="btn btn-primary ml-5" style="float:right;">Add Blog</button> <!-- Button to add a new blog post -->
                    </a>
                </div>
                <div class="header_wrap">
                    <div class="num_rows">
                        <div class="form-group">
                            <!-- Show Numbers Of Rows -->
                            <select class="form-control" name="state" id="maxRows">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="70">70</option>
                                <option value="100">100</option>
                                <option value="5000">Show ALL Rows</option>
                            </select> <!-- Dropdown to select the number of rows to display -->
                        </div>
                    </div>
                    <div class="tb_search">
                        <!-- Search bar for filtering table rows -->
                        <input type="text" id="search_input_all" onkeyup="FilterkeyWord_all_table()" placeholder="Search.." class="form-control">
                    </div>
                </div>
                <table class="table table-striped table-class" id="table-id">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Published Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Get the user ID based on the logged-in user's email
                        $get_user_id = "SELECT user_id FROM user WHERE email = '{$_SESSION['email']}'";
                        $user = mysqli_query($conn, $get_user_id);
                        $user_id = mysqli_fetch_assoc($user);

                        // Fetch blog posts created by the logged-in user and not deleted
                        $sql = "SELECT * FROM blog WHERE user_id='{$user_id['user_id']}' AND deleted_at = '0000-00-00 00:00:00'";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are any blog posts
                        if (!empty($result)) {
                            while ($data = mysqli_fetch_assoc($result)) {

                                // Fetch the category name for the blog post
                                $get_category_name = "SELECT category_name FROM category WHERE category_id = '{$data['category_id']}'";
                                $category = mysqli_query($conn, $get_category_name);
                                $category_name = mysqli_fetch_assoc($category);

                                // Wrap the blog description text
                                $wrapped_description = wordwrap($data['blog_description'], 95, "<br />\n");
                        ?>
                                <tr>
                                    <td><img class="" width="60px" height="60px" src="../../uploads/<?php echo $data['blog_image']; ?>" alt=""></td> <!-- Blog image -->
                                    <td><?php echo $category_name['category_name'] ?></td> <!-- Blog category -->
                                    <td><?php echo $data['blog_title'] ?></td> <!-- Blog title -->
                                    <td><?php echo $wrapped_description ?></td> <!-- Wrapped blog description -->
                                    <td><?php
                                        $timestamp = strtotime($data['created_at']);
                                        $formattedDate = date('d F Y', $timestamp);
                                        echo $formattedDate ?></td> <!-- Formatted creation date -->
                                    <td>
                                        <!-- Published status -->
                                        <?php if ($data['published_status'] == 0) { ?>
                                            <span class="status-text">Unpublished</span>
                                        <?php } else { ?>
                                            <span class="status-text">Published</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <!-- Action buttons to edit or delete the blog post -->
                                        <a href="update_blog.php?id=<?php echo $data['blog_id'] ?>" class="edit pr-2"><i class="fas fa-edit"></i></a>
                                        <a href="delete_blog.php?id=<?php echo $data['blog_id'] ?>" class="delete"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center"><b>No Blogs are found.<b></td></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Start Pagination -->
                <div class='pagination-container'>
                    <nav>
                        <ul class="pagination pb-5">
                            <!-- Here the JS Function Will Add the Rows -->
                        </ul>
                    </nav>
                </div>
                <div class="rows_count">Showing 11 to 20 of 91 entries</div>

            </div> <!-- End of Container -->
        </main>
    </div>

    <script src="js/myscript.js"></script> <!-- Custom scripts -->
</body>

</html>
