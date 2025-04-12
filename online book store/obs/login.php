<?php  
session_start();

# If the admin is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Book Store</title>

    <!-- Google Fonts for Futuristic Typography -->
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem 3rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 30px rgba(0, 187, 211, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            color: #00BBD3;
            text-align: center;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        h5 {
            font-family: 'Orbitron', sans-serif;
            color: #1E90FF;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #00BBD3;
            color: #FFFFFF;
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 187, 211, 0.8);
            border-color: #1E90FF;
            color: #FFFFFF;
        }

        .btn-login {
            background: linear-gradient(45deg, #00BBD3, #1E90FF);
            border: none;
            color: #FFFFFF;
            padding: 0.75rem;
            width: 100%;
            border-radius: 50px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 187, 211, 0.8);
            background: linear-gradient(45deg, #1E90FF, #00BBD3);
        }

        .alert-danger {
            background: rgba(255, 75, 75, 0.2);
            border: 1px solid #FF4B4B;
            color: #FFFFFF;
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form method="POST" action="php/auth.php">
            <h2>Admin Signin</h2>
            <h5>Login</h5>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>
            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" required>
            <input type="password" name="password" class="form-control" placeholder="Enter Your Password" required>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>
</html>

<?php } else {
    header("Location: admin.php");
    exit;
} ?>