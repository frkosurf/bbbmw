#!/bin/sh
INSTALL_DIR=`pwd`

# create directories
mkdir -p data tpl_c 

# create SQlite files
touch data/client.sqlite
chmod o+w data/client.sqlite

# initalize an empty data store if none is available
if [ ! -f data/data.php ]
then
    echo "<?php \$data = array(); ?>" > data/data.php
fi

if [ ! -f config.php ]
then
    cp config.php.default config.php
fi

# set permissions
chmod -R o+w data/ tpl_c/
chcon -R -t httpd_sys_rw_content_t data/ tpl_c/

echo "Deny from all" > data/.htaccess
