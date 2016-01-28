<?php
    require ('steamauthOOP.class.php');  
    $steam = new steamauthOOP();
    if (isset($_GET["logout"])) {
        $steam->logout();
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SteamAuthOOP Demo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .table {
            table-layout: fixed;
            word-wrap: break-word;
        }
    </style>
  </head>
  <body style="background-color: #EEE;">
    <div class="container" style="margin-top: 30px; margin-bottom: 30px; padding-bottom: 10px; background-color: #FFF;">
		<h1>SteamAuthOOP Demo</h1>
		<span class="small pull-left" style="padding-right: 10px;">for SteamAuthOOP 1.0</span>
		<hr>
		<?php
if(!$steam->loggedIn()) {
    echo "<div style='margin: 30px auto; text-align: center;'>Welcome Guest! <a href='";
    echo $steam->loginUrl();
    echo "'>Please log in!</a></div>";
	} else {
    echo "<div style='float:left;'><a href='https://github.com/blackcetha/steamauthoop'><button type='button' class='btn btn-success' style='margin: 2px 3px;'>GitHub Repo</button></a><a href='https://github.com/blackcetha/steamauthoop/releases'><button type='button' style='margin: 2px 3px;' class='btn btn-warning'>Download</button></a></div><br><br>
	<h4 style='margin-bottom: 3px; float:left;'>Steam WebAPI-Output: <small>There are more variables ready to use but not listed here as they are not always available.</small></h4><span style='float:right;'><a href='demo.php?logout'>Log out</a></span>
	<table class='table table-striped'><tr><td><b>Variable name</b></td><td><b>Value</b></td><td><b>Description</b></td></tr>
	<tr><td>\$steam->loggedIn()</td><td>".$steam->loggedIn()."</td><td>1 (true) - Logged in, 0 (false) - not</td></tr>
	<tr><td>\$steam->steamid</td><td>".$steam->steamid."</td><td>SteamID64 of the user</td></tr>
	<tr><td>\$steam->communityvisibilitystate</td><td>".$steam->communityvisibilitystate."</td><td>1 - Account not visible; 3 - Account is public (Depends on the relationship of your account to the others)</td></tr>
	<tr><td>\$steam->profilestate</td><td>".$steam->profilestate."</td><td>1 - The user has a Steam Community profile; 0 - if not</td></tr>
	<tr><td>\$steam->personaname</td><td>".$steam->personaname."</td><td>Public name of the user</td></tr>
	<tr><td>\$steam->lastlogoff</td><td>".$steam->lastlogoff."</td><td><a href='http://www.unixtimestamp.com/' target='_blank'>Unix timestamp</a> of the user's last logoff</td></tr>
	<tr><td>\$steam->profileurl</td><td>".$steam->profileurl."</td><td>Link to the user's profile</td></tr>
	<tr><td>\$steam->personastate</td><td>".$steam->personastate."</td><td>0 - Offline, 1 - Online, 2 - Busy, 3 - Away, 4 - Snooze, 5 - looking to trade, 6 - looking to play</td></tr>
	<tr><td>\$steam->realname</td><td>".$steam->realname."</td><td>\"Real\" name</td></tr>
	<tr><td>\$steam->primaryclanid</td><td>".$steam->primaryclanid."</td><td>The ID of the user's primary group</td></tr>
	<tr><td>\$steam->timecreated</td><td>".$steam->timecreated."</td><td><a href='http://www.unixtimestamp.com/' target='_blank'>Unix timestamp</a> for the time the user's account was created</td></tr>
	<tr><td>\$steam->avatar</td><td><img src='".$steam->avatar."'><br>".$steam->avatar."</td><td>Address of the user's 32x32px avatar</td></tr>
	<tr><td>\$steam->avatarmedium</td><td style=''><img src='".$steam->avatarmedium."'><br>".$steam->avatarmedium."</td><td>Address of the user's 64x64px avatar</td></tr>
	<tr><td>\$steam->avatarfull</td><td><img src='".$steam->avatarfull."'><br>".$steam->avatarfull."</td><td>Address of the user's 184x184px avatar</td></tr>
	</table>";
	}    
	?>
	<hr>
	<div class="pull-right"><i>This page is powered by <a href="http://steampowered.com">Steam</a></i></div>
	<a href="https://github.com/blackcetha/steamauthoop">GitHub Repo</a><br>
	Demo page by <a href="https://github.com/blackcetha" target="_blank">BlackCetha</a></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  </body>
</html>
