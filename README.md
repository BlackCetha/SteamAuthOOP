# SteamAuthOOP
OOP-based Steam-Login library

# Features
- One-File class
- Doesnt rely on an external library
- Easy to use
- Easy to modify with commented code and function reference
- Saves *all* information the Steam-API provides on a per-user basis
- Doesnt recreate/delete your session if you use it elsewhere

# Installation
- Drop the `steamauthoop.class.php` file into your projects directory
- Insert your API-Key from http://steamcommunity.com/dev/apikey into the config (`$settings["apikey"]`)
- Include it with `require "steamauthoop.class.php";`
- Initialize it with `$steam = new SteamAuthOOP();`

# Basic usage
If you want to have a link, go with
`<a href="<?php echo $steam->loginUrl(); ?>">Link</a>`


Check if the user is logged in with
`$steam->loggedIn();`
(Will return true or false)


User-Data is accessible through `$steam->varName;`
You can find a basic list of variables in the demo file or a more advanced one in the code.


### Example

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

# Planned
Nothing at the moment.
Open an issue if you think there is something that could be better.

# Data security
The library does not deliver safe/escaped data as it would limit the functionality.
This will leave your site vulnerable to cross-site-scripting ("XSS") and SQL-injection attacks if you dont take actions to prevent them.

### XSS
For example if a user calls himself `<script src='http://example.com/hacks.js'></script>` and you print that name to other users, their browser will download `hacks.js`.

You can prevent that by passing the string through `htmlspecialchars($string)`.

### SQL injection
For example if a user calls himself `"; DROP TABLE *;--` and you directly execute that as an SQL-query, you will loose all your data.

You can prevent that by passing the strings through `mysqli_escape_string($link, $string)` or `$mysqli->escape_string($string)`.

# Legal stuff
If you choose to use the steam web-api you need to follow the Steam Web API Terms of Use found at
http://steamcommunity.com/dev/apiterms

The marked code is taken from Syntax_Error's "Ultra Simple Steam-Login" Class found at ~<http://forums.steampowered.com/forums/showthread.php?t=1430511>~ (Link is dead, [archive version](https://web.archive.org/web/20170524123709/http://forums.steampowered.com/forums/showthread.php?t=1430511))
