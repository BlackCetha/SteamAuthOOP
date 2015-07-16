# SteamAuthOOP
OOP-based Steam-Login library

#Features
- One-File class
- Doesnt rely on an external library
- Easy to use
- Easy to modify with commented code and function reference
- Saves *all* information the Steam-API provides on a per-user basis
- Doesnt recreate/delete your session if you use it elsewhere

#Installation
- Drop the `steamauthoop.class.php` file into your projects directory
- Insert your API-Key from http://steamcommunity.com/dev/apikey into the config (`$settings["apikey"]`)
- Include it with `require "steamauthoop.class.php";`
- Initialize it with `$steam = new SteamAuthOOP();`

#Basic usage
If you want to have a link, go with
`<a href="<?php echo $steam->loginUrl(); ?>">Link</a>`


Check if the user is logged in with
`$steam->loggedIn();`
(Will return true or false)


User-Data is accessible through `$steam->varName;`
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

#Planned
* [ ] Streamline code
* [ ] Add option to skip API-query if you just need the SteamID


#Legal stuff
Since SteamAuthOOP is using the Steam Web-API you need to put the text "Powered by Steam" with a link to http://steampowered.com somewhere onto your page.

The marked code is taken from Syntax_Error's "Ultra Simple Steam-Login" Class found here: http://forums.steampowered.com/forums/showthread.php?t=1430511
