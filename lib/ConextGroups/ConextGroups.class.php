<?php

/*  
 *  FileTrader - Web based file sharing platform
 *  Copyright (C) 2011 François Kooman <fkooman@tuxed.net>
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

require_once ('ext/oauth/OAuth.php');

class ConextGroups extends Groups {
    private $_consumer; 
    private $_apiUri;

    function __construct($config, $auth = NULL) {
        parent::__construct($config, $auth);
        $this->_apiUri = getConfig($config, 'conext_group_api_uri', TRUE) . "/" . $auth->getUserId();
        $key = getConfig($config, 'conext_key', TRUE);
        $secret = getConfig($config, 'conext_secret', TRUE);
        $this->_consumer = new OAuthConsumer($key, $secret, NULL);
    }

	function getUserGroups() {
        $req = OAuthRequest::from_consumer_and_token($this->_consumer, NULL, "GET", $this->_apiUri, NULL);
        $method = new OAuthSignatureMethod_HMAC_SHA1();
        $req->sign_request($method, $this->_consumer, NULL);
        $hdr = $req->to_header();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_apiUri);
        curl_setopt($ch, CURLOPT_FAILONERROR, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ($hdr));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        // grab URL and pass it to the browser
        $data = curl_exec($ch);
        if(FALSE === $data) {
            die(curl_error($ch) . "<br>" . $data);
        }
        // close cURL resource, and free up system resources
        curl_close($ch);
        $jd = json_decode($data, TRUE);
        $groups = array();
        if(array_key_exists("entry", $jd)) {
            foreach($jd['entry'] as $k => $v) {
                $groups[$v['id']] = $v['title'];
            }
        }
		return $groups;
	}

	function addActivity($title = NULL, $body = NULL, $groupId = NULL) {
	}
}
?>
