<?php

require_once "ext/php-oauth-client/lib/OAuthTwoPdoCodeClient.php";

class ConextGroupsOAuth2 extends Groups {

    private $_consumer;
    private $_apiUri;
    private $_accessToken;

    function __construct($config, $auth = NULL) {
        parent::__construct($config, $auth);
        $this->_apiUri = getConfig($config, 'conext_group_api_uri', TRUE) . "/@me";

        $oauthConfig = array (
            'PdoPersistentConnection' => FALSE,
            'PdoDsn' => "sqlite:" . dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "client.sqlite",
            'PdoUser' => NULL,
            'PdoPass' => NULL,
            'clientId' => getConfig($config, 'conext_key', TRUE),
            'clientSecret' => getConfig($config, 'conext_secret', TRUE),
            'authorizeEndpoint' => getConfig($config, 'conext_authorize_uri', TRUE),
            'tokenEndpoint' => getConfig($config, 'conext_token_uri', TRUE),
            'redirectUri' => getConfig($config, 'conext_redirect_uri', TRUE),
           'TokensTableName' => getConfig($config, 'TokensTableName', TRUE),
            'StatesTableName' => getConfig($config, 'StatesTableName', TRUE),
        );

        $this->_consumer = new OAuthTwoPdoCodeClient($oauthConfig);
        $this->_consumer->setScope("read");
        $this->_consumer->setResourceOwnerId($auth->getUserId());
	//$this->_consumer->setLogFile("/tmp/log.txt");
    }

    function getUserGroups() {
        $output = $this->_consumer->makeRequest($this->_apiUri);
        $jd = json_decode($output, TRUE);
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
