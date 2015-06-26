<?php
/**
 *
 * @author BlackCetha
 * A class for OpenID-logins with steam
 * @documentation http://github.com/blackcetha/steamauthoop
*/
class steamauthOOP {
    public $steamid, $communityvisibilitystate, $profilestate, $personaname, $lastlogoff, $profileurl, $avatar, $avatarmedium, $avatarfull, $personastate, $realname, $primaryclanid, $timecreated, $gameserverip, $gameid, $gameextrainfo, $loccountrycode, $loccityid, $locstatecode = "";
    private $settings = array(
        "apikey" => "", // Get yours today from http://steamcommunity.com/dev/apikey
        "domainname" => "", // Displayed domain in the login-screen
        "loginpage" => "", // Returns to last page if not set
        "logoutpage" => ""
    );

    function __construct() {
        if (session_id() == "") session_start();  // Start a session if none exists
        if ($this->settings["apikey"] == "") die("<b>SteamAuthOOP:</b> Please supply a valid API-Key!");
        if ($this->settings["loginpage"] == "") $this->settings["loginpage"] = /* [ */ (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];  // Code (c) 2010 ichimonai.com, released under MIT-License
        if (isset($_GET["openid_assoc_handle"]) && !isset($_SESSION["steamdata"]["steamid"])) { // Did we just return from steam login-page? If so, validate idendity and save the data
            $steamid = $this->validate();
            if ($steamid != "") {  // ID Proven, get data from steam and save them
                $apiresp = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=1D8373E5C0CB0ABBA50FE893F5019811&steamids=".$steamid),true);
                foreach ($apiresp["response"]["players"][0] as $key => $value) $_SESSION["steamdata"][$key] = $value;
            }
        }
        if (isset($_SESSION["steamdata"]["steamid"])) { // If we are logged in, make user-data accessable through $steam->var
            foreach ($_SESSION["steamdata"] as $key => $value) $this->{$key} = $value;
        }
    }

    /**
     * Generate SteamLogin-URL
     * @copyright genUrl function (c) 2010 ichimonai.com, released under MIT-License
     * Modified by BlackCetha for OOP use
     */
    function loginUrl()
    {
        $params = array(
            'openid.ns'			=> 'http://specs.openid.net/auth/2.0',
            'openid.mode'		=> 'checkid_setup',
            'openid.return_to'	=> $this->settings["loginpage"],
            'openid.realm'		=> (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'],
            'openid.identity'	=> 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id'	=> 'http://specs.openid.net/auth/2.0/identifier_select',
        );
        return 'https://steamcommunity.com/openid/login' . '?' . http_build_query($params, '', "&");
    }

    /**
     * Redirects to steam-login
     */
    function goToSteam() {
        header("Location: ".$this->loginUrl());
    }

    /*
     * Validate data against Steam-Servers
     * @copyright genUrl function (c) 2010 ichimonai.com, released under MIT-License
     * Modified by BlackCetha for OOP use
     */
    private static function validate()
    {
        // Star off with some basic params
        $params = array(
            'openid.assoc_handle'	=> $_GET['openid_assoc_handle'],
            'openid.signed'			=> $_GET['openid_signed'],
            'openid.sig'			=> $_GET['openid_sig'],
            'openid.ns'				=> 'http://specs.openid.net/auth/2.0',
        );

        // Get all the params that were sent back and resend them for validation
        $signed = explode(',', $_GET['openid_signed']);
        foreach($signed as $item)
        {
            $val = $_GET['openid_' . str_replace('.', '_', $item)];
            $params['openid.' . $item] = get_magic_quotes_gpc() ? stripslashes($val) : $val; 
        }

        // Finally, add the all important mode. 
        $params['openid.mode'] = 'check_authentication';

        // Stored to send a Content-Length header
        $data =  http_build_query($params);
        $context = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 
                "Accept-language: en\r\n".
                "Content-type: application/x-www-form-urlencoded\r\n" .
                "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data,
            ),
        ));

        $result = file_get_contents("http://steamcommunity.com/openid/login", false, $context);

        // Validate wheather it's true and if we have a good ID
        preg_match("#^http://steamcommunity.com/openid/id/([0-9]{17,25})#", $_GET['openid_claimed_id'], $matches);
        $steamID64 = is_numeric($matches[1]) ? $matches[1] : 0;

        // Return our final value
        return preg_match("#is_valid\s*:\s*true#i", $result) == 1 ? $steamID64 : '';
    }
    function logout() {
        if (!$this->loggedIn()) return false;
        foreach ($_SESSION["steamdata"] as $key => $value) unset($this->{$key});
        unset($_SESSION["steamdata"]); // Delete the users info from the cache, DOESNT DESTROY YOUR SESSION!
        if (!isset($_SESSION[0])) session_destroy();  // End the session if theres no more data in it
        if ($this->settings["logoutpage"] != "") header("Location: ".$this->settings["logoutpage"]); // If the logout-page is set, go there
        return true;
    }
    function loggedIn() {
        return (isset($_SESSION["steamdata"]["steamid"]) && $_SESSION["steamdata"]["steamid"] != "") ? true : false;
    }
    function forceReload() {
        if (!isset($_SESSION["steamdata"]["steamid"])) return false; // User is not logged in, nothing to reload
        $apiresp = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=1D8373E5C0CB0ABBA50FE893F5019811&steamids=".$_SESSION["steamdata"]["steamid"]),true);
        foreach ($apiresp["response"]["players"][0] as $key => $value) $_SESSION["steamdata"][$key] = $value;
        foreach ($_SESSION["steamdata"] as $key => $value) $this->{$key} = $value; // Make user-data accessable through $steam->var
        return true;
    }
    /**
     * Prints debug information about steamauth
     */
    function debug() {
        echo "<h1>SteamAuth debug report</h1><hr><b>Settings-array:</b><br>";
        echo "<pre>".print_r($this->settings,true)."</pre>";
        echo "<br><br><b>Data:</b><br>";
        echo "<pre>".print_r($_SESSION["steamdata"],true)."</pre>";
    }
}
?>