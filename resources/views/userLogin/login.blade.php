<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - MySebenarnya</title>
  <style>
    * {
      box-sizing: border-box;
    }

    html, body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f8f4ee 0%, #f3ede4 100%);
      color: #2c2c2c;
      height: 100%;
    }

    .header {
      height: 80px;
      background: #5a4e7c;
      color: white;
      display: flex;
      align-items: center;
      padding: 0 2rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .header-title {
      font-size: 1.8rem;
      font-weight: bold;
      letter-spacing: 0.5px;
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 4rem 2rem;
      min-height: calc(100vh - 80px);
    }

    .login-box {
      display: flex;
      flex-direction: column;
      gap: 2rem;
      background: white;
      padding: 2.5rem 2rem;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
      width: 100%;
      max-width: 420px;
      position: relative;
      animation: fadeIn 0.6s ease;
    }

    .login-box::before {
      content: "";
      background: url('https://img.icons8.com/ios-filled/100/shield.png') no-repeat center;
      background-size: 40px;
      width: 40px;
      height: 40px;
      position: absolute;
      top: -20px;
      left: 20px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-title {
      font-size: 1.6rem;
      font-weight: 700;
      text-align: center;
      color: #5a4e7c;
    }

    .tagline {
      font-size: 0.95rem;
      color: #666;
      text-align: center;
      margin-top: -1rem;
    }

    .login-form {
      display: flex;
      flex-direction: column;
    }

    .login-input, .login-select {
      padding: 0.75rem 1rem;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
      margin-bottom: 1rem;
    }

    .login-input:focus, .login-select:focus {
      border-color: #5a4e7c;
      outline: none;
    }

    .login-select {
      background: #fff;
      appearance: none;
    }

    .login-button {
      background: #5a4e7c;
      color: white;
      border: none;
      padding: 0.75rem;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-button:hover {
      background: #483b66;
    }

    .login-footer {
      font-size: 0.9rem;
      text-align: center;
      color: #666;
    }

    .login-footer a {
      color: #5a4e7c;
      text-decoration: none;
      font-weight: 500;
    }

    .login-footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header class="header">
    <div class="header-title">MySebenarnya</div>
  </header>

  <div class="login-container">
    <div class="login-box">
      <h2 class="login-title">Log In to Verify Truth</h2>
      <p class="tagline">A trusted platform to assess the authenticity of public news reports.</p>
        @if ($errors->any())
        <div style="color: red; margin-bottom: 1rem;">
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

      <form class="login-form" method="POST" action="{{ route('login.submit') }}">
        @csrf
        <input type="username" name="username" class="login-input" placeholder="Username" required />
        <input type="password" name="password" class="login-input" placeholder="Password" required />

        <select name="role" class="login-select" required>
            <option value="" disabled selected>Select Role</option>
            <option value="public">Public User</option>
            <option value="mcmc">MCMC Staff</option>
            <option value="agency">Agency</option>
        </select>


        <button type="submit" class="login-button">Login</button>
    </form>


      <div class="login-footer">
        Don't have an account? <a href="#">Sign up</a>
      </div>
    </div>
  </div>
</body>
</html>