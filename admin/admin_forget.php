<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        .container{
            height: 150px;
            width: 300px;
            border: 2px solid black;
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            margin-top: 230px;
            margin-left: 500px;
            padding: 20px;
            
        }
        .container label{
            width: 220px;
            font-family: sans-serif;
            text-align: center;
            color: #ff7200;
            font-size: 22px;
            background-color: #fff;
            border-radius: 10px;
            margin: 2px;
            padding: 8px;
        }
        .container input{
            width: 270px;
            height: 25px;
            background: transparent;
            border-bottom: 1px solid #ff7200;
            border-top: none;
            border-right: none;
            border-left: none;
            color: #fff;
            font-size: 15px;
            letter-spacing: 1px;
            margin-top: 30px;
            font-family: sans-serif;
        }

        button{
            width: 240px;
            height: 40px;
            background: #ff7200;
            border: none;
            margin-top: 30px;
            margin-left: 20px;
            font-size: 18px;
            border-radius: 10px;
            cursor: pointer;
            color: #fff;
            transition: 0.4s ease;
            
        }
    </style>
</head>
<body>
    <form action="admin_forgetpassword.php" method="POST">
    <div class="container">
        <label>Enter your Email:</label><br>
        <input type="email" name="email" id="" placeholder="Enter your Email"><br>
        <button name="send-email-link">Submit</button>
    </div>
    </form>
</body>
</html>