<?php
	session_start();
	require("config.php");
	require("model.php");
	if(!empty($_POST)){
		$model = new Model($conn);
		$inserted = $model->getData($_POST);
		if($inserted && !empty($_SESSION['success'])){
			die($_SESSION['success']);
		}else{
			die($_SESSION['error']);
		}
		session_unset();
		$conn->close();
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="description" content="sign up " />
	<meta name="keywords" content=", sign up" />
	<meta name="author" content="Munaamullah Khan" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Login</title>

	<link rel="stylesheet" href="css/Munaamstyle.css" />
</head>

<body>
	<header>
		<a href="TBD">
			<h1 class="Logo"> Cacti-Succulent </h1>
		</a>
		<nav>
			<div class="dropdown-content">
				<ul class="link" id="mainUl">

					<li><a href="signup.php">Sign up</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
				</ul>
			</div>
		</nav>
		<a class="about" href="TBD">TBD</a>
	</header>
	<div class="prime">
		<form  id="form" action="login.php" method="POST">
		
			<fieldset>
				<legend>
					<h1 class="form">Login</h1>
				</legend>
				<div class="formdetails">
					<label for="funame"> User Name :* </label><input id="funame" name="funame" type="text"
						placeholder="User Name"/><br /><br /><br />
					<label for="pass"> Password :*</label>
					<input id="pass" type="password" name="pass" placeholder="Enter Password">
				</div>
			</fieldset>


			<fieldset id="buttons">
				<button class="fbutton" type="submit">Login</button>
			</fieldset>
			<div class="signup-link">Don't have an account?<a href="signup.php">&nbsp;&nbsp;Register Now</a></div>
		</form>




	</div>
	<!--footer-->
	<footer>
		<div class="foot-content">

			<div class="navbox">
				<h2> Navigator</h2>
				<ul>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD"> Home</a></li>
				</ul>
			</div>
			<div class="leftside">
				<h2>About Us</h2>
				<p>Cacti-Succulent Kuching is a local homegrown business specialized in selling various
					type and size of succulent plants. Apart from selling succulent plants, they also sell different
					type
					of gardening tools, soils and fertilizers at an affordable cost. Cacti-Succulent Kuching is setup in
					2020 in which business is running both at home as well as weekend market.</p>
				<h3>"We Bring Good Things to Life"</h3>
				<h3>Provide the Best Experience within a Single Touch.</h3>
			</div>
			<div class="rightside">
				<h2>Visit Us</h2>
				<h3>Social Media</h3>
				<ol>
					<li><a href="https://youtube.com" class="button" target="_blank">Youtube</a></li>
					<li><a href="https://facebook.com" class="button" target="_blank">Facebook</a></li>
					<li><a href="https://instagram.com" class="button" target="_blank">Instagram</a></li>
					<li><a href="https://whatsapp.com" class="button" target="_blank">Whatsapp</a></li>
				</ol>
			</div>
		</div>

	</footer>

</body>

</html>