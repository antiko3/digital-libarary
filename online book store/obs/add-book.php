<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

    # Database Connection File
    include "db_conn.php";

    # Category helper function
    include "php/func-category.php";
    $categories = get_all_categories($conn);

    # author helper function
    include "php/func-author.php";
    $authors = get_all_author($conn);

    if (isset($_GET['title'])) {
        $title = $_GET['title'];
    }else $title = '';

    if (isset($_GET['desc'])) {
        $desc = $_GET['desc'];
    }else $desc = '';

    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
    }else $category_id = 0;

    if (isset($_GET['author_id'])) {
        $author_id = $_GET['author_id'];
    }else $author_id = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book | Admin</title>
    
    <!-- Futuristic Design Elements -->
    <style>
        :root {
            --primary-blue: #0066ff;
            --dark-blue: #003366;
            --light-blue: #00ccff;
            --neon-blue: #00f7ff;
            --pure-white: #ffffff;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.18);
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background:  
                        url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            color: var(--dark-blue);
            overflow-x: hidden;
        }
        
        .futuristic-nav {
            backdrop-filter: blur(10px);
            background: rgba(0, 51, 102, 0.9);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid var(--glass-border);
        }
        
        .nav-link {
            color: var(--pure-white);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--neon-blue);
            text-shadow: 0 0 8px rgba(0, 247, 255, 0.6);
        }
        
        .nav-link.active {
            color: var(--neon-blue);
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            background: var(--neon-blue);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--neon-blue);
        }
        
        .futuristic-form {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(0, 102, 255, 0.2);
            border: 1px solid var(--glass-border);
        }
        
        .form-control, .form-select {
            border: 1px solid #ddd;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 102, 255, 0.25);
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .btn-futuristic {
            background: var(--primary-blue);
            color: var(--pure-white);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-futuristic:hover {
            background: var(--dark-blue);
            color: var(--pure-white);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .btn-futuristic::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0.3),
                rgba(255, 255, 255, 0)
            );
            transform: rotate(30deg);
        }
        
        .btn-futuristic:hover::after {
            animation: shine 1.5s infinite;
        }
        
        @keyframes shine {
            100% {
                left: 150%;
                top: 150%;
            }
        }
        
        .alert {
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.9);
            color: white;
        }
        
        .alert-success {
            background-color: rgba(25, 135, 84, 0.9);
            color: white;
        }
        
        h1 {
            font-family: 'Orbitron', sans-serif;
            font-weight: 600;
            background: linear-gradient(135deg, #0066ff 0%, #00ccff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark futuristic-nav mb-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">
                    <i class="fas fa-user-shield me-2"></i>Admin Panel
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="fas fa-store me-1"></i>Store
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="add-book.php">
                                <i class="fas fa-book-medical me-1"></i>Add Book
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-category.php">
                                <i class="fas fa-layer-group me-1"></i>Add Grade
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-author.php">
                                <i class="fas fa-users me-1"></i>Add Section
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <form action="php/add-book.php"
              method="post"
              enctype="multipart/form-data" 
              class="futuristic-form p-4 mx-auto"
              style="max-width: 800px;">

            <h1 class="text-center pb-4 display-4 fs-3">
                <i class="fas fa-plus-circle me-2"></i>Add New Book
            </h1>
            
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?=htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>
            
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?=htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-heading me-1"></i>Book Title
                        </label>
                        <input type="text" 
                               class="form-control"
                               value="<?=$title?>" 
                               name="book_title"
                               placeholder="Enter book title">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-align-left me-1"></i>Book Description
                        </label>
                        <input type="text" 
                               class="form-control" 
                               value="<?=$desc?>"
                               name="book_description"
                               placeholder="Enter book description">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-users me-1"></i>Book Section
                        </label>
                        <select name="book_author" class="form-select">
                            <option value="0">Select section</option>
                            <?php 
                            if ($authors != 0) {
                                foreach ($authors as $author) { 
                                    $selected = ($author_id == $author['id']) ? 'selected' : '';
                                    echo "<option value='{$author['id']}' $selected>{$author['name']}</option>";
                                }
                            } 
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-layer-group me-1"></i>Book Grade
                        </label>
                        <select name="book_category" class="form-select">
                            <option value="0">Select Grade</option>
                            <?php 
                            if ($categories != 0) {
                                foreach ($categories as $category) { 
                                    $selected = ($category_id == $category['id']) ? 'selected' : '';
                                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                                }
                            } 
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-image me-1"></i>Book Cover
                        </label>
                        <input type="file" 
                               class="form-control" 
                               name="book_cover"
                               accept="image/*">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-file-alt me-1"></i>Book File
                        </label>
                        <input type="file" 
                               class="form-control" 
                               name="file"
                               accept=".pdf,.doc,.docx,.epub">
                    </div>
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-futuristic btn-lg w-100">
                        <i class="fas fa-plus-circle me-2"></i>Add Book
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
} ?>