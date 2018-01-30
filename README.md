# InterSession

##Erreur 500
Si vous rencontrez l'erreur 500 :
"GET /index.php" 500 pour laravel

Il faut effectuer la commande suivante au sein du répertoire du projet  
sudo chmod 755 -R <répertoire du projet> :

Puis effectuer la commande suivante sur le répertoire storage au sein du projet :  
chmod -R o+w <répertoire du projet>/storage
