<!--
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Create Account</h1>

  <form action="login/submit" method="post">
    <label for="userName">Name: </label>
    <input type="text" name="userName" placeholder="username"> <br>

    <label for="password">Password: </label>
    <input type="password" name="password" placeholder="password">  <br>

    <label for="email">Email: </label>
    <input type="email" name="email" placeholder="Email Address">  <br>

    <button type="submit">Create</button>

    <h4>Already Registered? <a href="/login">Sign In</a></h4>
  </form>
</body>
</html>
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
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
      <h3 class="card-title text-center mb-4">Create Account</h3>
      <form action="login/submit" method="post">
        <div class="mb-3">
          <label for="userName" class="form-label">Name</label>
          <input type="text" name="userName" id="userName" class="form-control" placeholder="Enter your name" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Type your password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Account</button>

        <p class="text-center mt-3">
          Already registered? <a href="/land">Sign In</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
