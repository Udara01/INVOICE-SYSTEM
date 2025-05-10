<!--DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Login Page</h1>
  <form action="user/login" method="post">
    <label for="userName">UserName: </label>
    <input type="text" name="userName" placeholder="username"> <br>

    <label for="password">Password: </label>
    <input type="password" name="password" placeholder="password"> <br>

    <button type="submit">Login</button>

    <h4>Not Registered? <a href="/signup">Create an account</a></h4>
  </form>
</body>
</html-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/asset/Images/admin-bg.jpg') no-repeat center center fixed;
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
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
      <h3 class="card-title text-center mb-4">Login</h3>
      <form action="user/login" method="post">
        <div class="mb-3">
          <label for="userName" class="form-label">Username</label>
          <input type="text" name="userName" id="userName" class="form-control" placeholder="Enter your username" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <p class="text-center mt-3">
          Not registered? <a href="/signup">Create an account</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
