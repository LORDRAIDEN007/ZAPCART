<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(120deg, #84fab0, #8fd3f4);
            color: #333;
        }
        .thank-you-container {
            text-align: center;
            background: #fff;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .thank-you-container h1 {
            font-size: 2.5em;
            color: #2c3e50;
        }
        .thank-you-container p {
            margin: 15px 0;
            font-size: 1.2em;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <h1>Thank You!</h1>
        <p>Thank you for shopping with us! We look forward to serving you again soon!</p>
        <a href="http://localhost:8080/zapcart2.0/screen/scripts/script_back.php?cart_id=1" class="back-button">Go Back</a>
    </div>
</body>
</html>
