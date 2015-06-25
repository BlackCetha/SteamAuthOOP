# SteamAuthOOP
OOP-based rewrite of SmiTH197's SteamAuthentication https://github.com/smith197/steamauthentication

#Installation
- Drop the `steamauthoop.class.php` file into your projects directory
- Insert your API-Key from http://steamcommunity.com/dev/apikey into the config (`$settings["apikey"]`)
- Include it with `require "steamauthoop.class.php";`
- Initialize it with `$steam = new SteamAuthOOP();`

#Basic usage
You can redirect the user to the steam loginscreen with
`$steam->goToSteam();`

If you want to have a link, go with
`<a href="<?php $steam->loginUrl(); ?>">Link</a>`


Check if the user is logged in with
`$steam->loggedIn();`
(Will return true or false)


Userdata is accessible through `$steam->varName;`
You can find a basic list of variables in the demo file or a more advanced one in the code.


###Example

```php
<?php
  require("steamauthoop.class.php");
  $steam = new SteamAuthOOP();
  if ($steam->loggedIn()) {
    echo "Hello ".$steam->personaname."!";
  } else {
    echo "<a href='".$steam->loginUrl()."'>Login</a>";
  }
?>
```



###Legal stuff
Since SteamAuthOOP uses the Steam Web-API you need to put the text "Powered by Steam" with a link to http://steampowered.com somewhere into your page.

The marked code is taken from Syntax_Error's "Ultra Simple Steam-Login" Class found here: http://forums.steampowered.com/forums/showthread.php?t=1430511
