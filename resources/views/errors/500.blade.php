<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Server Error</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f85032, #e73827);
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
            font-size: 120px;
            margin: 0;
            color: #fff;
            position: relative;
            animation: shake 1.5s infinite ease-in-out;
        }
        h1 span {
            color: #f9d342;
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
            background: #f85032;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
            border: 2px solid #fff;
        }
        a:hover {
            background: #e73827;
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

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-10px);
            }
            50% {
                transform: translateX(10px);
            }
            75% {
                transform: translateX(-10px);
            }
        }

        .gear {
            width: 100px;
            height: 100px;
            margin: 20px auto;
            background: #f9d342;
            border-radius: 50%;
            position: relative;
            animation: rotate 5s linear infinite;
        }

        .gear::before,
        .gear::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="gear"></div>
        <h1>500</h1>
        <p>Oops! Something went wrong on our end.</p>
        <p>Please try refreshing the page or come back later.</p>
        <a href="{{ url('/') }}">Return to Home</a>
    </div>
</body>
</html>
