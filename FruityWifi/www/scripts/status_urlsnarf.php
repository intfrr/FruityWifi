<? 
/*
	Copyright (C) 2013  xtr4nge [_AT_] gmail.com

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<?
include "../login_check.php";
include "../config/config.php";
include "../functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($_GET["page"], "../msg.php", $regex_extra);
    regex_standard($iface_wifi, "../msg.php", $regex_extra);
}

$service = $_GET['service'];
$action = $_GET['action'];
$page = $_GET['page'];

if($service == "urlsnarf") {
    if ($action == "start") {
        // COPY LOG
        $exec = "cp ../logs/urlsnarf.log ../modules/urlsnarf/includes/logs/".gmdate("Ymd-H-i-s").".log";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"", $dump);

        $exec = "echo '' > ../logs/urlsnarf.log";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
        $exec = "/usr/sbin/urlsnarf -i $iface_wifi >> ../logs/urlsnarf.log &";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    } else if($action == "stop") {
        $exec = "killall urlsnarf";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    }
}

if ($page == "list") {
    header('Location: ../page_modules.php');    
} else if ($page == "module") {
    //header('Location: ../modules/dnsspoof/index.php');
    header('Location: ../modules/action.php?page=urlsnarf');
} else {
    header('Location: ../page_status.php');
}

?>