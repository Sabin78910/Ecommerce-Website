<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            color: #fff;
        }
        .container {
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        h1 {
            font-size: 150px;
            margin: 0;
            position: relative;
            display: inline-block;
            animation: float 2s infinite ease-in-out;
        }
        h1 span {
            color: #ff6b6b;
        }
        p {
            font-size: 24px;
            margin: 20px 0;
            line-height: 1.6;
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
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .planet {
            position: absolute;
            top: -150px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 200px;
            background: #ff6b6b;
            border-radius: 50%;
            box-shadow: 0 0 50px rgba(255, 107, 107, 0.8);
            z-index: -1;
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: translateX(-50%) rotate(0deg);
            }
            to {
                transform: translateX(-50%) rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="planet"></div>
        <h1><span>4</span>0<span>4</span></h1>
        <p>Oops! The page you were looking for doesn't exist.</p>
        <a href="{{ url('/') }}">Return to Home</a>
    </div>
</body>
</html>
