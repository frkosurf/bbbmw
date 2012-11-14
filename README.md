# BigBlueButton Middleware
The following components are required:

* PHP 5.3.x
* Smarty (PHP template engine)
* simpleSAMLphp (if you want to use SSPAuth for authenticating)

For simpleSAMLphp a system wide installation is recommended. See 
`docs/SURFconext.txt` for more information on configuring simpleSAMLphp for use 
with SURFconext, other identity federations will differ somewhat in 
configuration.

# Installation

    $ git clone https://github.com/fkooman/bbbmw.git
    $ sh docs/configure.sh
    $ sh docs/install_dependencies.sh

If you want to use `ConextGroupsOAuth2` run the following to initialize the
database:

    $ php docs/init_oauth_db.php

Copy `config.php.default` to `config.php`:

    $ cp config.php.default config.php

Now you can modify it to match your configuration. Set at least the URL to 
the BigBlueButton API and the salt as configured in BBB.

If you want to use a simple test configuration with plain username and password
authentication use SimpleAuth and SimpleGroups and configure them in 
`config.php`.

# SELinux Configuration
Set the correct SELinux labels (only for Fedora/Red Hat systems?)

    $ chcon -R -t httpd_sys_rw_content_t data/ tpl_c/

Allow HTTP to access the network (to contact BBB)

    $ su -c 'setsebool -P httpd_can_network_connect on'

(The -P flag makes the setting persistent across reboots)
