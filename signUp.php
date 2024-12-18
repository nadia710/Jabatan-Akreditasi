<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <style>
        body{
            font-family : Arial, sans-serif;
            background : #f4f4f4;
            display : flex;
            justify-content : center;
            align-items : center;
            height : 100vh;
            margin : 0;
			background-image : url('signup1.png');
			background-repeat : no-repeat;
			background-size : cover;
        }

        .container{
            background : black;
			opacity : 70%;
            padding : 10px 50px 40px;
            border-radius : 20px;
            color : white;
            margin-bottom : 10px;
        }

        .container label{
            padding : 10px;
            display : block;
            margin-bottom : 5px;
        }

        .container input{
            padding : 10px;
            margin-bottom : 10px;
            border : 1px solid #ccc;
            border-radius : 10px;
        }

        button {
			justify-content : center;
			align-items :center;
			padding : 10px 15px 10px 15px;
			border-radius : 10px;
		}	
		
		button:hover {
			color : #787472;
		}
		
		.link a{
			text-decoration : none;
			color : black;
		}
		
		.link a:hover {
			color : #333130;
		}
    </style>
</head>
<body>
    <form role = "form" method = "post" action = "saveSignUp.php">
        <div class = "container">
            <h1><center>Sign Up</center></h1>
            <p><center>Create your account</center></p>
            <hr>

            <center><input type = "text" placeholder = "Enter your username" name = "user"></center>
            <center><input type = "password" placeholder = "Enter password" name = "password"></center>
            <center><input type = "password" placeholder = "Confirm password" name = "confirm"></center>
        </div>

        <div class = "button">
            <center><button type = "reset" class = "clearbtn">Clear</button>
            <button type = "submit" class = "signupbtn">Sign Up</button></center>
        </div>
		
		<div class = "link">
			<center><label><a href = "login.php">Already have an account?</a></label></center>
			<br>
		</div>
    </form>

    <script>
        function showPassword(){
            var x = document.getElementById("password");
            if(x.type === "password"){
                x.type = "text";
            }
            else{
                x.type = "password";
            }
        }

    </script>
</body>
</html>