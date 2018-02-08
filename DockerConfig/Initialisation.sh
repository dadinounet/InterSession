#!/bin/bash
echo "#---------------------------------------------#"
echo "#           _                      _          #"
echo "#     _ __ | |__   ___   ___ _ __ (_)_  __    #"
echo "#    | '_ \| '_ \ / _ \ / _ \ '_ \| \ \/ /    #"
echo "#    | |_) | | | | (_) |  __/ | | | |>  <     #"
echo "#    | .__/|_| |_|\___/ \___|_| |_|_/_/\_\    #"
echo "#    |_|                                      #"
echo "#         Install Docker Environnement        #"
echo "#---------------------------------------------#"
echo ""
echo ""
echo "Do you have change .env file ?"
read -p "Press any key to continue... " -n1 -s
docker-compose up -d

if [ "$(docker ps | grep app)" ]
then
    docker-compose exec app php KrakenSecurity/artisan key:generate
    docker-compose exec app php KrakenSecurity/artisan migrate
    docker-compose exec app php KrakenSecurity/artisan passport:install
    docker-compose exec app php KrakenSecurity/artisan optimize
else
        echo "Error"
fi

