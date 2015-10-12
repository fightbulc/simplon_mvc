#!/bin/bash

#
# clear screen
#
clear

DATE=`date +%Y%m%d_%H%M%S`
ENV=live
BRANCH=master
REPO=git@github.com:big-pun-injections/pushcast_app.git
COMPOSER=/usr/local/bin/composer
APP_PATH=/home/www/pushcast-app

echo ""
echo "--------------------- DEPLOY APP LIVE --------------------";
echo ""

echo "$APP_PATH"
echo ""
ssh root@144.76.250.136 -p22222 "cd $APP_PATH && git clone -b $BRANCH $REPO $DATE && $COMPOSER selfupdate && cd $DATE && $COMPOSER install && $COMPOSER dumpautoload -o && cd ../ && chown -R 501:dialout $DATE"

echo ""
echo "--------------------- MIGRATE DB PRODUCTION --------------------";
echo ""

ssh root@144.76.250.136 -p22222 "$APP_PATH/$DATE/vendor/bin/phinx migrate -e $ENV -c $APP_PATH/$DATE/phinx.php"

echo ""
echo "---------------------- SWITCH LIVE ON --------------------";
echo ""

echo "$DATE --> current"
ssh root@144.76.250.136 -p22222 "ln -sfn $APP_PATH/$DATE $APP_PATH/current"

echo ""
echo "------------------------ RESTART FPM ----------------------";
echo ""

ssh root@144.76.250.136 -p22222 "/etc/init.d/php-fpm restart"

echo ""
echo "---------------------- NEWRELIC: EVENT --------------------";
echo ""

ssh root@144.76.250.136 -p22222 "curl -s -H "x-api-key:223cc9f0ca535c59c983c31625a998d89422d93bb118f63" -d "deployment[app_name]=pushcast-app" https://api.newrelic.com/deployments.xml"

echo ""
echo "Done. Au revoir, cherrie!";
echo ""
