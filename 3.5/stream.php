<?php
/*
*  stream.php - Displays the camera the stream to only authenticated users
*
*  Copyright (C) 2015  Kyle T. Gabriel
*
*  This file is part of Mycodo
*
*  Mycodo is free software: you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation, either version 3 of the License, or
*  (at your option) any later version.
*
*  Mycodo is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with Mycodo. If not, see <http://www.gnu.org/licenses/>.
*
*  Contact at kylegabriel.com
*/

require_once("includes/auth.php");

if ($_COOKIE['login_hash'] == $user_hash) {
	$server = "localhost"; // camera server address
	$port = 6926; // camera server port
	$url = "/?action=stream"; // image url on server
	set_time_limit(0);  
	$fp = fsockopen($server, $port, $errno, $errstr, 30); 
	if (!$fp) { 
	        echo "$errstr ($errno)<br>\n";   // error handling
	} else {
	        $urlstring = "GET ".$url." HTTP/1.0\r\n\r\n"; 
	        fputs ($fp, $urlstring); 
	        while ($str = trim(fgets($fp, 4096))) 
	        header($str); 
	        fpassthru($fp); 
	        fclose($fp); 
	}
}
?>