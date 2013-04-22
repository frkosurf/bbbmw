<?php

/*
 *  BBBmw - BigBlueButton Middleware
 *  Copyright (C) 2011 Franois Kooman <fkooman@tuxed.net>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function logHandler($message) {
	if(isset($_SERVER['REMOTE_ADDR'])) {
		$caller = $_SERVER['REMOTE_ADDR'];
	} else {
		$caller = 'php-cli';
	}
	file_put_contents('data/BigBlueButton.log', "---[".$caller." @ ".date("c",time())."]---\n".$message."\n", FILE_APPEND);
	return $message;
}

function getRequest($variable = NULL, $required = FALSE, $default = NULL) {
	if (!isset ($_REQUEST)) {
		throw new Exception("no request available, not called using browser?");
	}
	if ($variable === NULL || empty ($variable)) {
		throw new Exception("no variable specified or empty");
	}
	if ($required) {
		if (!isset ($_REQUEST[$variable])) {
			throw new Exception("$variable not available while required");
		}
		return $_REQUEST[$variable];
	}
	if (isset ($_REQUEST[$variable])) {
		return $_REQUEST[$variable];
	}
	return $default;
}

function getConfig($config = array (), $variable = NULL, $required = FALSE, $default = NULL) {
	if (!is_array($config)) {
		throw new Exception("no usable configuration array, broken or missing config file?");
	}
	if ($variable === NULL || empty ($variable)) {
		throw new Exception("no variable specified or empty");
	}
	if ($required) {
		if (!isset ($config[$variable])) {
			throw new Exception("$variable not available while required");
		}
		return $config[$variable];
	}
	if (isset ($config[$variable])) {
		return $config[$variable];
	}
	return $default;
}

function getProtocol() {
	if(!isset($_SERVER['SERVER_NAME'])) {
		return FALSE;
	}
	return (isset ($_SERVER['HTTPS']) && !empty ($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
}

function getContents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}
?>
