<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/style.css">
    <title>Rent a car - Signup</title>
</head>
<body>
    
    <div class="container">
        <h2>Create Account</h2>

        <form id="signupForm">
            <input type="text" name="fullName" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit"> Sign Up</button>
        </form>

        <p id="responseMsg"></p>

    </div>

    <script src="../../../public/js/jquery.min.js"></script>
    <script src="../../../public/js/signup.js"></script>
</body>
</html>