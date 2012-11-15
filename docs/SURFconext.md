# BigBlueButton Configuration
First set the correct values in the configuration file `config.php`:

	$config['auth_type']            = 'SSPAuth';
	$config['ssp_path']             = '/var/simplesamlphp';
	$config['ssp_sp']               = 'BigBlueButton';
	$config['ssp_dn_attr']          = 'displayName';
    $config['ssp_org_attr']         = 'schacHomeOrganization';

    $config['group_type']           = 'ConextGroupsOAuth2';
    $config['conext_authorize_uri'] = 'https://api.surfconext.nl/v1/oauth2/authorize';
    $config['conext_token_uri']     = 'https://api.surfconext.nl/v1/oauth2/token';
    $config['conext_group_api_uri'] = 'https://api.surfconext.nl/v1/social/rest/groups';
    $config['conext_key']           = '12345';
    $config['conext_secret']        = '54321';
    $config['conext_redirect_uri']  = 'http://localhost/bbbmw/index.php';

    $config['restrict_create_org']  = array();

Replace `12345` and `54321` with your obtained key and secret from SURFconext
and `conext_redirect_uri` with the location at which you installed this 
software.

# simpleSAMLphp Configuration
We assume you have a default `simpleSAMLphp` configuration. We will be using
a persistent NameID to uniquely identify users and the `displayName` 
attribute to show the name of the user in the conference. The 
`schacHomeOrganization` attribute is used to filter who can create/end a
conference.

First the `config/authsources.php` of simpleSAMLphp:

    'BigBlueButton' => array(
        'saml:SP',
        'entityID' => NULL,
        'idp' => 'https://engine.surfconext.nl/authentication/idp/metadata',
        'discoURL' => NULL,
        'name' => array(
            'en' => 'BigBlueButton Web Conferencing',
        ),
        'description' => array(
            'en' => 'BigBlueButton enables universities and colleges to deliver a high-quality learning experience to remote students.',
        ),
        'attributes' => array(
            'urn:oid:1.3.6.1.4.1.25178.1.2.9',   // schacHomeOrganization
            'urn:oid:2.16.840.1.113730.3.1.241', // displayName
        ),
        'attributes.required' => array(
            'urn:oid:1.3.6.1.4.1.25178.1.2.9',   // schacHomeOrganization
            'urn:oid:2.16.840.1.113730.3.1.241', // displayName
        ),
        'acs.Bindings' => array (
            'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST'
        ),
        'NameIDPolicy' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
    ),

Next configure SURFconext as remote IdP in `metadata/saml20-idp-remote.php`:

    $metadata['https://engine.surfconext.nl/authentication/idp/metadata'] = array (
        'SingleSignOnService' => 'https://engine.surfconext.nl/authentication/idp/single-sign-on',
        'certFingerprint'     => array('a36aac83b9a552b3dc724bfc0d7bba6283af5f8e'),
        'authproc' => array(
            50 => array(
                'class' => 'core:AttributeMap', 'oid2name',
            ),
        ),
    );

For more up to data information see the SURFconext wiki [here](https://wiki.surfnetlabs.nl/display/surfconextdev/simpleSAMLphp+and+SURFconext).
