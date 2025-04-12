<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Section | Admin</title>
    
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .futuristic-nav {
            backdrop-filter: blur(10px);
            background: rgba(0, 51, 102, 0.9);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid var(--glass-border);
            width: 100%;
            margin-bottom: 2rem;
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
        
        .navbar-nav {
            display: flex;
            gap: 1rem;
        }
        
        .futuristic-form {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(0, 102, 255, 0.2);
            border: 1px solid var(--glass-border);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .form-control {
            border: 1px solid #ddd;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 102, 255, 0.25);
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-control::placeholder {
            color: #666;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-blue);
        }
        
        .btn-futuristic {
            background: var(--primary-blue);
            color: var(--pure-white);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            width: 100%;
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
            padding: 0.75rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .futuristic-form {
                padding: 1.5rem;
                max-width: 90%;
            }
            
            h1 {
                font-size: 1.5rem;
            }
            
            .navbar-nav {
                gap: 0.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .form-control {
                font-size: 0.9rem;
                padding: 0.6rem;
            }
            
            .btn-futuristic {
                font-size: 0.9rem;
                padding: 0.6rem;
            }
            
            h1 {
                font-size: 1.25rem;
            }
        }
    </style>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5.1.1 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
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
                            <a class="nav-link" href="add-book.php">
                                <i class="fas fa-book-medical me-1"></i>Add Book
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-category.php">
                                <i class="fas fa-layer-group me-1"></i>Add Grade
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="add-author.php">
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
        
        <form action="php/add-author.php" method="post" class="futuristic-form p-4 mx-auto">
            <h1>
                <i class="fas fa-plus-circle me-2"></i>Add New Section
            </h1>
            
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>
            
            <?php if (isset($_GET['success'])) { ?>
                <div садаalert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>
            
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-users me-1"></i>Section Name
                </label>
                <input type="text" 
                       class="form-control" 
                       name="author_name" 
                       placeholder="Enter section name" 
                       required>
            </div>
            
            <button type="submit" class="btn btn-futuristic">
                <i class="fas fa-plus-circle me-2"></i>Add Section
            </button>
        </form>
    </div>
</body>
</html>

<?php } else {
    header("Location: login.php");
    exit;
} ?>