#!/usr/bin/env bash

if (whiptail --title "Confirmation du script" --yesno "Toutes les images et container vont être supprimé. Voulez-vous continuer ?" 10 60) then
	#Clear docker instance
	docker stop $(docker ps -a -q)
	docker rm $(docker ps -a -q)
	docker rmi $(docker images -q)

	docker volume rm $(docker volume ls)

	#Start docker
	#docker-compose up

	#mkdir -p config
    #touch config/postfix-accounts.cf
    #docker run --rm \
    #  -e MAIL_USER=admin@admin.tld \
    #  -e MAIL_PASS=admin \
    #  -ti tvial/docker-mailserver:latest \
    #  /bin/sh -c 'echo "$MAIL_USER|$(doveadm pw -s SHA512-CRYPT -u $MAIL_USER -p $MAIL_PASS)"' >> config/postfix-accounts.cf
else
	echo "Annulation du script"
fi

