<?php 
session_start();
if(isset($_SESSION['fname'])){
    $loc = $_SESSION['startup'];
    include_once './sharedkeys.php';
    header("Loaction:" . WEBSITE_URL . $loc);
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Relaxoda Soft Access Page</title>
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/login.php/style.css" />
        <script src="js/modernizr.custom.63321.js"></script>
        <!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
        <style>
            @import url(http://fonts.googleapis.com/css?family=Ubuntu:400,700);
            body {
                background: #563c55 url(images/blurred.jpg) no-repeat center top;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                background-size: cover;
            }
            .container > header h1,
            .container > header h2 {
                color: #fff;
                text-shadow: 0 1px 1px rgba(0,0,0,0.7);
            }
        </style>
    </head>
    <body>
        <div class="container">

            <header>

                <h1>Access <strong>Relaxoda Soft</strong> Services</h1>
                <h2>Welcome</h2>
                <div class="support-note">
                    <span class="note-ie">Sorry, only modern browsers.</span>
                </div>

            </header>

            <section class="main">
                <form class="form-3" method="post" action="letmein.php">
                    <p class="clearfix">
                        <label for="login">Username</label>
                        <input type="text" name="login" id="login" placeholder="Username">
                    </p>
                    <p class="clearfix">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password"> 
                    </p>
                    <p class="clearfix">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me</label>
                    </p>
                    <p class="clearfix">
                        <input type="submit" name="submit" value="Sign in">
                    </p>       
                </form>​
            </section>

        </div>
    </body>
</html>