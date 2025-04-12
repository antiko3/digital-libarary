<?php
session_start();

# If search key is not set or empty
if (!isset($_GET['key']) || empty($_GET['key'])) {
    header("Location: index.php");
    exit;
}
$key = $_GET['key'];

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = search_books($conn, $key);

# Author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>empty Books</title>

    <!-- Bootstrap 5.3.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Google Fonts: Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        /* 2030 Blue and White Theme */
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
            position: relative;
            margin: 0;
        }

        /* Subtle Background Animation */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1512820790803-83ca7342f27f') no-repeat center center/cover;
            opacity: 0.2;
            z-index: -1;
            animation: fade 8s infinite;
        }

        @keyframes fade {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.3; }
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 80px 20px;
            background: url('https://images.unsplash.com/photo-1512820790803-83ca7342f27f') no-repeat center center/cover;
            background-attachment: fixed;
            position: relative;
            color: #ffffff;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 123, 255, 0.4);
            z-index: 1;
        }

        .hero-section h1, .hero-section p {
            position: relative;
            z-index: 2;
        }

        .hero-section h1 {
            font-size: 3rem;
            text-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
        }

        .hero-section p {
            font-size: 1.2rem;
            font-weight: 300;
        }

        /* Glassmorphism Navbar */
        .glass-nav {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .navbar-brand, .nav-link {
            color: #ffffff !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #007bff !important;
            text-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
        }

        /* Search Title */
        .search-title {
            font-size: 1.8rem;
            text-align: center;
            margin: 30px 0;
            color: #007bff;
            text-shadow: 0 0 5px rgba(0, 123, 255, 0.4);
        }

        .search-title span {
            font-weight: 700;
        }

        /* Book Cards */
        .modern-card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 123, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 280px;
            overflow: hidden;
            margin: 10px;
        }

        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 123, 255, 0.4);
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid rgba(0, 123, 255, 0.1);
        }

        .card-body {
            padding: 15px;
            color: #333;
        }

        .card-title {
            font-size: 1.3rem;
            color: #007bff;
            font-weight: 700;
        }

        .card-text {
            font-size: 0.85rem;
            line-height: 1.5;
            color: #555;
        }

        /* Buttons */
        .modern-btn {
            border-radius: 25px;
            padding: 8px 18px;
            font-size: 0.85rem;
            font-weight: 400;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-open {
            background: #007bff;
            color: #ffffff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
        }

        .btn-open:hover {
            background: #0056b3;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.6);
        }

        .btn-download {
            background: #ffffff;
            color: #007bff;
            border: 1px solid #007bff;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.4);
        }

        .btn-download:hover {
            background: #f0f0f0;
            box-shadow: 0 0 12px rgba(255, 255, 255, 0.6);
        }

        /* Alert Styling */
        .alert-warning {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            border-radius: 10px;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .alert-warning img {
            margin-bottom: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }
            .hero-section p {
                font-size: 1rem;
            }
            .modern-card {
                width: 100%;
                max-width: 300px;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>MHA bookstore
        </h1>
        <p>Your Result</p>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg glass-nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">MHA book store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <a class="nav-link" href="admin.php">Admin</a>
                        <?php } else { ?>
                            <a class="nav-link" href="login.php">Login</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2 class="search-title">Search Result for <span><?php echo htmlspecialchars($key); ?></span></h2>

        <div class="d-flex pt-3 flex-wrap justify-content-center">
            <?php if (empty($books)) { ?>
                <div class="alert alert-warning" role="alert">
                    <img src="https://via.placeholder.com/80?text=No+Results" alt="No results" width="80">
                    <br>
                    The key <b>"<?php echo htmlspecialchars($key); ?>"</b> didn't match any record in the database.
                </div>
            <?php } else { ?>
                <?php foreach ($books as $book) { ?>
                    <div class="modern-card">
                        <img src="Uploads/cover/<?php echo htmlspecialchars($book['cover']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($book['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                            <p class="card-text">
                                <i><b>By:
                                    <?php foreach ($authors as $author) {
                                        if ($author['id'] == $book['author_id']) {
                                            echo htmlspecialchars($author['name']);
                                            break;
                                        }
                                    } ?>
                                <br></b></i>
                                <?php echo htmlspecialchars($book['description']); ?>
                                <br><i><b>Category:
                                    <?php foreach ($categories as $category) {
                                        if ($category['id'] == $book['category_id']) {
                                            echo htmlspecialchars($category['name']);
                                            break;
                                        }
                                    } ?>
                                <br></b></i>
                            </p>
                            <a href="Uploads/files/<?php echo htmlspecialchars($book['file']); ?>" class="btn modern-btn btn-open">Open</a>
                            <a href="Uploads/files/<?php echo htmlspecialchars($book['file']); ?>" class="btn modern-btn btn-download" download="<?php echo htmlspecialchars($book['title']); ?>">Download</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>