<?php	
	require_once 'db.php';
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jabatan Akreditasi</title>
	<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src = "https://kit.fontawesome.com/18f5dc28c3.js" crossorigin="anonymous"></script>


    <style>
        body{
            font-family : Garamond;
            justify-content : center;
            align-items : center;
            height : 100vh;
            margin : 0;
        }

        .container{
            padding : 10px 50px 40px;
            border-radius : 20px;
            color : black;
        }

        .container label{
            padding : 10px;
            display : block;
            text-align : center;
            margin-bottom : 5px;
        }

        .container input{
            padding : 10px;
            margin-bottom : 10px;
            border : 1px solid #ccc;
            border-radius : 10px;
        }

        .button a{
            text-decoration : none;
            color : black;
        }

        .button{
            justify-content : space-between;
            align-items : center;
            text-align : center;
        }

        .clearbtn, .loginbtn{
            padding : 10px 20px;
            border : none;
            border-radius : 4px;
            cursor : pointer;
        }

        .clearbtn{
            background : #f44336;
            color : black;
        }

        .loginbtn{
            background : #48b873;
            color : black;
        }
		
		.clearbtn:hover{
			background : #adabaa;
		}
		
		.loginbtn:hover{
			background : #adabaa;
		}
    </style>
	</script>
</head>

<body>
	<form role = "form" method = "post" action = "saveLogin.php">
		<div class = "container">
			<h1><center> Login </center></h1>
			<p><center> Log Into Your Account </center></p>
			<hr>

			<center><input type = "text" placeholder = "Enter your username" name = "user"> </center>
			<center><input type = "password" placeholder = "Enter password" name = "password"></center>
			<center><label><input type = "checkbox" name = "show" onclick = "showPassword()"> Show Password</label></center>
		</div>

		<div class = "button">
			<button type = "reset" class = "clearbtn"> Clear </button>
			<button type = "submit" class = "loginbtn"> Login</button>
			<br>
			<center><label><a href = "signUp.php"> Don't have any account yet? </a></label></center>
		</div>
	</form>

    <script>
        function showPassword() {
            var x = document.getElementById("password");
            if(x.type === "password"){
                x.type = "text";
            }
            else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>