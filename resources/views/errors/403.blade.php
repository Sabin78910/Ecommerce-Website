<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            overflow: hidden;
        }
        .container {
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        h1 {
            font-size: 100px;
            margin: 0;
            color: #fff;
            position: relative;
            animation: bounce 2s infinite;
        }
        p {
            font-size: 24px;
            margin: 20px 0;
        }
        a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background: #ff6b6b;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        a:hover {
            background: #e63946;
            transform: scale(1.1);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .shield {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            background: radial-gradient(circle, #ff6b6b 0%, #e63946 70%);
            border-radius: 50%;
            box-shadow: 0 0 50px rgba(255, 107, 107, 0.8);
            position: relative;
            animation: rotate 5s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .shield:before,
        .shield:after {
            content: '';
            position: absolute;
            background: #fff;
            width: 30px;
            height: 80px;
            border-radius: 15px;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .shield:after {
            width: 70px;
            height: 30px;
            top: auto;
            bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="shield"></div>
        <h1>403</h1>
        <p>You don't have enough privilege for this action.</p>
        <p>Want to log in to an admin account?</p>
        <a href="{{ url('/login') }}">Return to Login</a>
    </div>
</body>
</html>
