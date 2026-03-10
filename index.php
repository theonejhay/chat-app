<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <style>
    body {
      background-color: #f5f5f5;
      transition: background-color 0.3s ease;
    }
    .login-container {
      margin-top: 20px;
    }
    .login-box {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 20px;
      background-color: #fff;
      transition: background-color 0.3s ease;
    }
    .dark-mode {
      background-color: #333333 !important;
    }
    .dark-mode .login-box {
      background-color: #222222 !important;
    }
    .dark-mode body {
      color: #ffffff;
    }
    #darkModeToggle:hover {
      transform: scale(1.1);
    }
    .dark-mode h3 {
      color: #ffffff; 
    }
    #darkModeToggle {
      position: absolute;
      top: 20px;
      right: 20px;
    }
    
  </style>
</head>
<body>

  <div class="container-fluid">
    <div class="row justify-content-center login-container">
      <div class="col-md-6 col-lg-4">
        <form action="verify-login.php" method="post" class="login-box">
          <div class="mb-3 text-center">
            <h3 class="fw-bold mb-4">LOG IN</h3>
          </div>
          <div class="mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" placeholder="Username" name="username">
              <label for="floatingInput">Username</label>
            </div>
          </div>
          <div class="mb-4">
            <div class="form-floating">
              <input type="password" class="form-control" name="password" placeholder="Password">
              <label for="password">Password</label>
            </div>
          </div>
          <button type="submit" id="login" class="btn btn-primary form-control">Login</button>
        </form>
        <div class="text-center mt-3">
          <button id="darkModeToggle" class="btn btn-secondary">Dark Mode</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

    darkModeToggle.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
    });
  </script>

</body>
</html>
