<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

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
    <title>Admin Dashboard - Book Store</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.2 CDN -->
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
        }

        .container {
            padding: 2rem;
        }

        a {
            text-decoration: none;
        }
        /* Navbar */
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
            max-width: 30rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #00BBD3;
            color: #FFFFFF;
            border-radius: 10px;
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
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .input-group-text:hover {
            background: #1E90FF;
            box-shadow: 0 0 15px #1E90FF;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .alert-success {
            background: rgba(0, 255, 128, 0.2);
            border: 1px solid #00FF80;
            color: #FFFFFF;
        }

        .alert-danger {
            background: rgba(255, 75, 75, 0.2);
            border: 1px solid #FF4B4B;
            color: #FFFFFF;
        }

        .alert-warning {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #00BBD3;
            color: #FFFFFF;
            padding: 2rem;
        }

        /* Tables */
        .table {
            border-radius: 10px;
        }

        .table thead {
            background: background:  
                        url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
;
        }

        .table th, .table td {
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(0, 187, 211, 0.2);
            box-shadow: 0 0 15px rgba(0, 187, 211, 0.5);
        }

        .table img {
            border-radius: 5px;
        }

        .link-dark {
            color: #FFFFFF !important;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .link-dark:hover {
            color: #1E90FF !important;
            text-shadow: 0 0 10px #1E90FF;
        }

        /* Headings */
        h4 {
            font-family: 'Orbitron', sans-serif;
            color: #00BBD3;
            text-align: center;
            margin: 2rem 0 1rem;
            text-transform: uppercase;
        }

        /* Buttons */
        .btn-warning, .btn-danger {
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
            margin: 0.25rem;
            transition: all 0.3s ease;
            font-family: 'Roboto', sans-serif;
        }

        .btn-warning {
            background: linear-gradient(45deg, #FFD700, #FFA500);
            border: none;
            color: #FFFFFF;
        }

        .btn-danger {
            background: linear-gradient(45deg, #FF4B4B, #B22222);
            border: none;
            color: #FFFFFF;
        }

        .btn-warning:hover, .btn-danger:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">Admin Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Store</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-category.php">Add Grade</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-author.php">Add Section</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <form action="search.php" method="get">
            <div class="input-group my-5">
                <input type="text" class="form-control" name="key" placeholder="Search Book..." aria-label="Search Book..." aria-describedby="basic-addon2">
                <button class="input-group-text btn" id="basic-addon2">
                    <img src="img/search.png" width="20" alt="Search">
                </button>
            </div>
        </form>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_GET['success']); ?>
            </div>
        <?php } ?>

        <!-- Books Table -->
        <?php if (empty($books)) { ?>
            <div class="alert alert-warning text-center p-5" role="alert">
                <img src="img/empty.png" width="100" alt="Empty">
                <br>
                There is no book in the database
            </div>
        <?php } else { ?>
            <h4>All Books</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Num</th>
                        <th>Title</th>
                        <th>Section</th>
                        <th>Description</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 0;
                    foreach ($books as $book) {
                        $i++;
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td>
                            <img width="100" src="Uploads/cover/<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                            <a class="link-dark d-block text-center" href="Uploads/files/<?= htmlspecialchars($book['file']) ?>">
                                <?= htmlspecialchars($book['title']) ?>    
                            </a>
                        </td>
                        <td>
                            <?php 
                            if (empty($authors)) {
                                echo "Undefined";
                            } else {
                                foreach ($authors as $author) {
                                    if ($author['id'] == $book['author_id']) {
                                        echo htmlspecialchars($author['name']);
                                        break;
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($book['description']) ?></td>
                        <td>
                            <?php 
                            if (empty($categories)) {
                                echo "Undefined";
                            } else {
                                foreach ($categories as $category) {
                                    if ($category['id'] == $book['category_id']) {
                                        echo htmlspecialchars($category['name']);
                                        break;
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit-book.php?id=<?= htmlspecialchars($book['id']) ?>" class="btn btn-warning">Edit</a>
                            <a href="php/delete-book.php?id=<?= htmlspecialchars($book['id']) ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>

        <!-- Categories Table -->
        <?php if (empty($categories)) { ?>
            <div class="alert alert-warning text-center p-5" role="alert">
                <img src="img/empty.png" width="100" alt="Empty">
                <br>
                There is no Grade in the database
            </div>
        <?php } else { ?>
            <h4>All Grades</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Num</th>
                        <th>Grade Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $j = 0;
                    foreach ($categories as $category) {
                        $j++;
                    ?>
                    <tr>
                        <td><?= $j ?></td>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td>
                            <a href="edit-category.php?id=<?= htmlspecialchars($category['id']) ?>" class="btn btn-warning">Edit</a>
                            <a href="php/delete-category.php?id=<?= htmlspecialchars($category['id']) ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>

        <!-- Authors Table -->
        <?php if (empty($authors)) { ?>
            <div class="alert alert-warning text-center p-5" role="alert">
                <img src="img/empty.png" width="100" alt="Empty">
                <br>
                There is no Section in the database
            </div>
        <?php } else { ?>
            <h4>All Sections</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Num</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $k = 0;
                    foreach ($authors as $author) {
                        $k++;
                    ?>
                    <tr>
                        <td><?= $k ?></td>
                        <td><?= htmlspecialchars($author['name']) ?></td>
                        <td>
                            <a href="edit-author.php?id=<?= htmlspecialchars($author['id']) ?>" class="btn btn-warning">Edit</a>
                            <a href="php/delete-author.php?id=<?= htmlspecialchars($author['id']) ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</body>
</html>

<?php } else {
    header("Location: login.php");
    exit;
} ?>