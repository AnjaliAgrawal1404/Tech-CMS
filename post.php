<?php
include 'includes/db_config.php'; // Include database configuration file

// Function to truncate text for recent post and display blog in PHP
// This function shortens the text to a maximum length and appends "..." if necessary
function truncateText($text, $maxLength = 100)
{
    if (strlen($text) > $maxLength) {
        $text = substr($text, 0, $maxLength) . '...';
    }
    return $text;
}

// Pagination setup
$results_per_page = 4; // Number of blog posts to show per page

// Search functionality
$search_query = "";
if (isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['query']); // Sanitize search query to prevent SQL injection
}

// Calculate total pages
// Query to count total number of blog posts matching the search query
$sql = "SELECT COUNT(blog_id) AS total FROM blog WHERE published_status='1' AND deleted_at = '0000-00-00 00:00:00' AND (blog_title LIKE '%$search_query%' OR blog_description LIKE '%$search_query%')";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_pages = ceil($row["total"] / $results_per_page); // Calculate total number of pages

// Determine the current page number
if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = (int)$_GET["page"];
} else {
    $page = 1; // Default to the first page if no page number is specified
}

// Calculate the starting record for the current page
$start_from = ($page - 1) * $results_per_page;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech CMS Blog</title>
    <?php include 'includes/header.php'; ?> <!-- Include header file -->
</head>
<body>
    <div class="container-fluid blog-container">
        <div class="blog-section row m-0">
            <?php
            // Query to get blog posts for the current page with optional search functionality
            $sql = "SELECT * FROM blog WHERE published_status='1' AND deleted_at = '0000-00-00 00:00:00' AND (blog_title LIKE '%$search_query%' OR blog_description LIKE '%$search_query%') LIMIT $start_from, $results_per_page";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // Loop through each blog post and display it
                while ($data = mysqli_fetch_assoc($result)) {
                    // Fetch user name based on user_id
                    $get_user_id = "SELECT full_name FROM user WHERE user_id = '{$data['user_id']}'";
                    $user = mysqli_query($conn, $get_user_id);
                    $user_id = mysqli_fetch_assoc($user);

                    // Fetch category name based on category_id
                    $get_category_name = "SELECT category_name FROM category WHERE category_id = '{$data['category_id']}'";
                    $category = mysqli_query($conn, $get_category_name);
                    $category_name = mysqli_fetch_assoc($category);
            ?>
                    <div class="col-md-6">
                        <div class="blog-post">
                            <!-- Display blog post image -->
                            <img src="./../uploads/<?php echo $data['blog_image']; ?>" alt="Image Placeholder">
                            <div class="blog-content">
                                <h4><?php echo $data['blog_title']; ?></h4>
                                <p>
                                    <?php echo truncateText($data['blog_description'], 100); ?>
                                    <a href="single_post.php?id=<?php echo $data['blog_id']; ?>">Read More</a>
                                </p>
                                <div class="blog-meta">
                                    <i class="fas fa-user"></i> <?php echo $user_id['full_name']; ?>
                                    <span class="separator">|</span>
                                    <i class="fas fa-tag"></i> <?php echo $category_name['category_name']; ?>
                                    <span class="separator">|</span>
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php
                                    $timestamp = strtotime($data['created_at']);
                                    $formattedDate = date('d F Y', $timestamp);
                                    echo $formattedDate;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No Blogs available.</p>'; // Message when no blogs are available
            }
            ?>
        </div>

        <div class="sidebar">
            <div class="search-bar mb-4">
                <h4>Search</h4>
                <form id="searchForm" action="post.php" method="GET">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" name="query" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="post.php" class="btn btn-dark">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="recent-posts">
                <h4>Recent Posts</h4>
                <ul class="list-group">
                    <?php
                    // Query to get the most recent 4 blog posts
                    $sql = "SELECT * FROM blog WHERE published_status='1' AND deleted_at = '0000-00-00 00:00:00' ORDER BY created_at DESC LIMIT 4";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each recent blog post and display it
                        while ($data = mysqli_fetch_assoc($result)) {
                            // Fetch user name based on user_id
                            $get_user_id = "SELECT full_name FROM user WHERE user_id = '{$data['user_id']}'";
                            $user = mysqli_query($conn, $get_user_id);
                            $user_id = mysqli_fetch_assoc($user);

                            // Fetch category name based on category_id
                            $get_category_name = "SELECT category_name FROM category WHERE category_id = '{$data['category_id']}'";
                            $category = mysqli_query($conn, $get_category_name);
                            $category_name = mysqli_fetch_assoc($category);
                    ?>
                            <li class="list-group-item d-flex align-items-center">
                                <img src="./../uploads/<?php echo $data['blog_image']; ?>" class="rounded-circle" alt="Image Placeholder">
                                <span>
                                    <?php echo truncateText($data['blog_description'], 50); ?>
                                    <a href="single_post.php?id=<?php echo $data['blog_id']; ?>">Read More</a>
                                    <div class="blog-meta">
                                        <i class="fas fa-user"></i> <?php echo $user_id['full_name']; ?>
                                        <span class="separator">|</span>
                                        <i class="fas fa-tag"></i> <?php echo $category_name['category_name']; ?>
                                    </div>
                                </span>
                            </li>
                    <?php
                        }
                    } else {
                        echo 'No recent posts available.'; // Message when no recent posts are available
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <!-- Previous page link -->
            <?php if ($page > 1) { ?>
                <li class="page-item"><a class="page-link" href="post.php?page=<?php echo $page - 1; ?>&query=<?php echo urlencode($search_query); ?>">Previous</a></li>
            <?php } ?>

            <!-- Page number links -->
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="post.php?page=<?php echo $i; ?>&query=<?php echo urlencode($search_query); ?>"><?php echo $i; ?></a></li>
            <?php } ?>

            <!-- Next page link -->
            <?php if ($page < $total_pages) { ?>
                <li class="page-item"><a class="page-link" href="post.php?page=<?php echo $page + 1; ?>&query=<?php echo urlencode($search_query); ?>">Next</a></li>
            <?php } ?>
        </ul>
    </nav>
</body>
</html>
