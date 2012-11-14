#!/bin/sh

rm -rf ext/
mkdir -p ext/

# php-oauth-client
(
cd ext/
git clone https://github.com/fkooman/php-oauth-client.git
)

# Bootstrap
(
cd ext/
curl -O http://twitter.github.com/bootstrap/assets/bootstrap.zip
unzip -q bootstrap.zip
rm bootstrap.zip
)

# OAuth
(
cd ext/
svn co https://oauth.googlecode.com/svn/code/php/ oauth
)

# Smarty
(
cd ext/
svn co http://smarty-php.googlecode.com/svn/trunk/distribution/ smarty
)
