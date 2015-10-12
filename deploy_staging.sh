#!/bin/bash

DATE=`date +%Y%m%d_%H%M%S`
ENV=stage
BRANCH=develop
REPO=git@github.com:big-pun-injections/pushcast_app.git
COMPOSER=/usr/local/bin/composer
APP_PATH=/home/www/pushcast-app-stage

#
# clear screen
#
clear

echo ""
echo "--------------------- DEPLOY APP STAGE --------------------";
echo ""

echo "$APP_PATH"
echo ""
ssh root@144.76.250.136 -p22222 "cd $APP_PATH && git clone -b $BRANCH $REPO $DATE && cd $DATE && $COMPOSER selfupdate && $COMPOSER install && $COMPOSER dumpautoload -o && cd ../ && chown -R 501:dialout $DATE"

echo ""
echo "--------------------- MIGRATE DB STAGE --------------------";
echo ""

ssh root@144.76.250.136 -p22222 "$APP_PATH/$DATE/vendor/bin/phinx migrate -e $ENV -c $APP_PATH/$DATE/phinx.php"

echo ""
echo "---------------------- SWITCH STAGE ON --------------------";
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

ssh root@144.76.250.136 -p22222 "curl -s -H "x-api-key:223cc9f0ca535c59c983c31625a998d89422d93bb118f63" -d "deployment[app_name]=pushcast-app-stage" https://api.newrelic.com/deployments.xml"

echo ""
echo "Done. Au revoir, cherrie!";
echo ""
