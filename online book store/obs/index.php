<?php 
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

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
    <title>Book Store</title>
    <link rel="icon" href="img/mha.jpeg">

    <!-- Google Fonts for Futuristic Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <style>
        body {
            background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover;
            color: #FFFFFF;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        

        .container {
            padding: 2rem;
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(0, 187, 211, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 0 20px rgba(0, 187, 211, 0.5);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar-brand, .nav-link {
            color: #FFFFFF !important;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #1E90FF !important;
            text-shadow: 0 0 10px #1E90FF;
        }

        /* Search Bar */
        .input-group {
            margin: 3rem 0;
        }

        a {
            text-decoration: none;
            color: white;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #00BBD3;
            color: #FFFFFF;
            box-shadow: 0 0 10px rgba(0, 187, 211, 0.5);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 187, 211, 0.8);
            border-color: #1E90FF;
        }

        .input-group-text {
            background: #00BBD3;
            border: none;
            transition: all 0.3s ease;
        }

        .input-group-text:hover {
            background: #1E90FF;
            box-shadow: 0 0 15px #1E90FF;
        }

		.input-group-text::placeholder {
            color: white;
            box-shadow: 0 0 15px #1E90FF;
        }

        /* Book Cards */
        .pdf-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            max-width: 300px;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 30px rgba(0, 187, 211, 0.7);
        }

        .card-img-top {
            border-radius: 20px 20px 0 0;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-family: 'Orbitron', sans-serif;
            color: #00BBD3;
            margin-bottom: 1rem;
        }

        .card-text {
            color: #E0E0E0;
            font-family: 'Roboto', sans-serif;
            font-size: 0.9rem;
        }

        .btn-success, .btn-primary {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-success {
            background: #00BBD3;
            border: none;
        }

        .btn-primary {
            background: #1E90FF;
            border: none;
        }

        .btn-success:hover, .btn-primary:hover {
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
            transform: scale(1.05);
        }

        /* Category and Author Lists */
        .category {
            margin-left: 2rem;
        }

        .list-group-item {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #FFFFFF;
            margin-bottom: 0.5rem;
            border-radius: 10px;
            font-family: 'Roboto', sans-serif;
            transition: all 0.3s ease;
        }

        .list-group-item-action:hover {
            background: #00BBD3;
            font-family: 'Roboto', sans-serif;
            color: #FFFFFF;
            box-shadow: 0 0 15px rgba(0, 187, 211, 0.5);
        }

        .list-group-item.active {
            background: linear-gradient(45deg, #00BBD3, #1E90FF);
            border: none;
        }

        /* Empty State */
        .alert-warning {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
            font-family: 'Roboto', sans-serif;
            border: 1px solid #00BBD3;
            border-radius: 20px;
            text-align: center;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.html">Online Digital Library</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Store</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="a2.html">About</a>
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

        <form action="search.php" method="get" style="width: 100%; max-width: 60rem;">
            <div class="input-group my-5">
                <input type="text" class="form-control" name="key" placeholder="Search Book..." aria-label="Search Book..." aria-describedby="basic-addon2">
                <button class="input-group-text btn" id="basic-addon2">
                    <img src="img/search.png" width="20" alt="Search">
                </button>
            </div>
        </form>

        <div class="d-flex pt-3">
            <?php if (empty($books)) { ?>
                <div class="alert alert-warning text-center p-5" role="alert">
                    <img src="img/empty.png" width="300px" alt="Empty">
                    <br>
                    There is no book in the database
                </div>
            <?php } else { ?>
                <div class="pdf-list">
                    <?php foreach ($books as $book) { ?>
                        <div class="card">
                            <img src="uploads/cover/<?php echo htmlspecialchars($book['cover']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($book['title']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                                <p class="card-text">
                                    <i><b>Section: 
                                        <?php 
                                        foreach ($authors as $author) {
                                            if ($author['id'] == $book['author_id']) {
                                                echo htmlspecialchars($author['name']);
                                                break;
                                            }
                                        }
                                        ?>
                                    </b></i><br>
                                    <?php echo htmlspecialchars($book['description']); ?><br>
                                    <i><b>Grade: 
                                        <?php 
                                        foreach ($categories as $category) {
                                            if ($category['id'] == $book['category_id']) {
                                                echo htmlspecialchars($category['name']);
                                                break;
                                            }
                                        }
                                        ?>
                                    </b></i>
                                </p>
                                <a href="uploads/files/<?php echo htmlspecialchars($book['file']); ?>" class="btn btn-success">Open</a>
                                <a href="Uploads/files/<?php echo htmlspecialchars($book['file']); ?>" class="btn btn-primary" download="<?php echo htmlspecialchars($book['title']); ?>">Download</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="category">
                <!-- List of categories -->
                <div class="list-group">
                    <?php if (empty($categories)) {
                        // do nothing
                    } else { ?>
                        <a href="#" class="list-group-item list-group-item-action active">Grade</a>
                        <?php foreach ($categories as $category) { ?>
                            <a href="category.php?id=<?php echo htmlspecialchars($category['id']); ?>" class="list-group-item list-group-item-action"><?php echo htmlspecialchars($category['name']); ?></a>
                        <?php } ?>
                    <?php } ?>
                </div>

                <!-- List of authors -->
                <div class="list-group mt-5">
                    <?php if (empty($authors)) {
                        // do nothing
                    } else { ?>
                        <a href="#" class="list-group-item list-group-item-action active">Section</a>
                        <?php foreach ($authors as $author) { ?>
                            <a href="author.php?id=<?php echo htmlspecialchars($author['id']); ?>" class="list-group-item list-group-item-action"><?php echo htmlspecialchars($author['name']); ?></a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>