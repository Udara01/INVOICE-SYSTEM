<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

    </style>
</head>
<body>

    <h1 class="mb-4">Welcome to Admin Portal</h1>
    <button class="btn btn-warning btn-lg" onclick="showLogin()">Login</button>

    <div class="login-form mt-4" id="loginForm">
        
    </div>

    <script>
    function showLogin() {
        fetch("<?= base_url('login') ?>")
            .then(response => response.text())
            .then(html => {
                document.getElementById('loginForm').innerHTML = html;
                document.getElementById('loginForm').style.display = 'block';
            })
            .catch(error => console.error('Error loading login form:', error));
            document.querySelector('button[onclick="showLogin()"]').style.display = 'none';

    }
    
  </script>
</body>
</html>
