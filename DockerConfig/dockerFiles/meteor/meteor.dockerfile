FROM node:latest
EXPOSE 80
RUN /bin/bash -c " apt-get update \
    && apt-get install -y curl git unzip nano tar ca-certificates imagemagick build-essential libssl-dev \
    && curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.33.8/install.sh -o install_nvm.sh \
    && chmod +x install_nvm.sh && ./install_nvm.sh  "
RUN /bin/bash -c " NVM_DIR=\"/usr/bin/.nvm\" && echo $NVM_DIR && ls -la $HOME/.nvm && mv $HOME/.nvm /usr/bin/.nvm"
RUN /bin/bash -c "chmod 755 -R /usr/bin/.nvm && /usr/bin/.nvm/nvm.sh install 8.9.4 && /usr/bin/.nvm/nvm.sh use 8.9.4 && /usr/bin/.nvm/nvm.sh alias default 8.9.4 && /usr/bin/.nvm/nvm.sh use default \
    && npm install -g express && npm link express \
    && mkdir /var/www && cd /var/www \
    && curl https://install.meteor.com/ | sh \ 
    && npm install \
    && meteor update --allow-superuser \
    && meteor npm install --save @babel/runtime \
    && meteor --allow-superuser"
    # gitclone ?






#install docker meteor
# docker pull node
# docker run -dit --name server_meteor --link `echo $(docker ps -qaf "name=server_laravel")` -p 9000:3000 node
#Récupération du contenu de la branch frontend
# docker exec -it server_meteor bash -c "
# apt-get update -y --fix-missing;
# apt-get upgrade -y;
# apt-get install -y sudo curl git unzip nano tar ca-certificates imagemagick;
# apt-get install -y iputils-ping net-tools;
# apt-get update -y --fix-missing;
# apt-get install -y build-essential libssl-dev;
# curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.33.8/install.sh -o install_nvm.sh;
# bash install_nvm.sh;
# source ~/.profile;
# nvm install 8.9.4;
# nvm use 8.9.4;
# nvm alias default 8.9.4;
# nvm use default;
# npm install -g express;
# npm link express;
# mkdir /var/www;
# cd /var/www;
# curl https://install.meteor.com/ | sh;
# git clone -b frontend https://github.com/WalpaSecurity/Walpa.git;
# cd /var/www/Walpa/FrontendWalpa;
# pwd;
# curl https://install.meteor.com/ | sh;
# npm install;
# chown -Rh root:root .meteor/
# meteor update --allow-superuser;
# meteor npm install --save @babel/runtime;
# meteor --allow-superuser;