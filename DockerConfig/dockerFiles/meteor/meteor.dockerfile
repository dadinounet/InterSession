FROM node:latest
RUN apt-get upgrade -y
RUN apt-get update -y
RUN apt-get install -y systemd
RUN apt-get install -y sudo curl git unzip nano tar ca-certificates imagemagick \
    python rsync software-properties-common wget
RUN apt-get install -y iputils-ping net-tools apt-utils
RUN apt-get update -y --fix-missing
RUN apt-get install -y build-essential libssl-dev
RUN curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.33.8/install.sh -o install_nvm.sh && bash install_nvm.sh
RUN chmod 755 ~/.nvm/nvm.sh
RUN ~/.nvm/nvm.sh install 8.9.4
RUN ~/.nvm/nvm.sh use 8.9.4
RUN ~/.nvm/nvm.sh alias default 8.9.4
RUN ~/.nvm/nvm.sh use default
RUN npm install -g express
RUN npm link express
RUN mkdir /var/www
RUN cd /var/www && curl https://install.meteor.com/ | sh
RUN cd /var/www && git clone https://github.com/dadinounet/InterSessionFront.git && cd InterSessionFront
RUN cd /var/www/InterSessionFront && curl https://install.meteor.com/ | sh
RUN cd /var/www/InterSessionFront && npm install
RUN cd /var/www/InterSessionFront && meteor update --allow-superuser
RUN cd /var/www/InterSessionFront && rm package-lock.json && meteor npm install --save @babel/runtime
RUN cd /var/www/InterSessionFront && meteor add session --allow-superuser
ENTRYPOINT cd /var/www/InterSessionFront && meteor --allow-superuser
