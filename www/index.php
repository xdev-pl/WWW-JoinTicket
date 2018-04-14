<?php
	
  include "config.php";
	
  $ip = $_SERVER['REMOTE_ADDR'];

  $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $scode . '&response='. $_POST['g-recaptcha-response']);

  $odp = json_decode($check);

  if ($odp->success == true)
  {
		$connect = @new mysqli($db_host, $db_user, $db_password, $db_name);
		$result = $connect->query("SELECT * FROM tickets WHERE ip='$ip'");
		$howm_login = $result-> num_rows;
		
		if ($howm_login>0)
			{ 
				$_SESSION['i'] = "Twoje konto jest już zweryfikowane!";
			}
		else
		{
			if ($connect->query("INSERT INTO tickets VALUES ('$ip')"))
				{

					$_SESSION['i'] = "Konto zostało zweryfikowane możesz wejść do gry!";

				}
		}

			$connect->close();
  }
	else
		{
			$_SESSION['i'] = "Potwierdź, że nie jesteś botem!";
		}

?>


<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">
		<link rel="icon" href="favicon.png" type="image/x-icon"/>
		<link rel="stylesheet" href="https://bootswatch.com/4/cosmo/bootstrap.css">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<meta charset="UTF-8" />
		<meta name="description" content="McJoinTicket" />
		<title>McJoinTicket - Zabezpieczenie</title>
	</head>
	
	<body>

		<div class="container" style="width: 330px; margin-top: 200px;">
			<p class="text-center"><?php  echo $_SESSION['i']; ?></p>
				<h3>Weryfikacja Konta Gracza</h3>
				<form method="post">
					<div class="g-recaptcha" data-sitekey="<?php echo $pcode; ?>"></div>
					<button type="submit" class="btn btn-primary mt-2">Zweryfikuj</button>
				</form>
		</div>

	</body>	
</html>