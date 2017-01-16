

function createWP()
{
  # Récupération des differentes variables
  nombdd = $5'_'$1
  bddId = $2
  bddPwd = $3
  adresseIp = $4
  titreSite = $6
  idUserSite = $7
  pwdUserSite = $8
  mail = $9

   # Téléchargement de wp-cli
  sudo curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

  chmod +x wp-cli.phar
  $ sudo mv wp-cli.phar /usr/local/bin/wp

  cd /var/www/html
  mkdir $titreSite
  cd $titreSite

  wp core download

  wp core config --dbname=$nombdd --dbuser=$bddId --dbpass=$bddPwd --locale=en_EN
  wp db create

  wp core install --url=$adresseIp --title=$titreSite --admin_user=$idUserSite --admin_password=$pwdUserSite --admin_email=$mail --skip-email


  # ajoute le code dans le fichier 000-default.conf
  textToAdd = "<Directory /var/www/html/wpcli>
                Options Indexes FollowSymlinks
                AllowOverride All
                Require all granted
        </Directory>"
sudo sed -i '13i\$textToAdd' '/etc/apache2/sites-available/000-default.conf'

# Modification du ficheir de config
textConf = "<ifModule mod_rewrite.c>
RewriteEngine On
</ifModule>"
echo $textConf >> "/etc/apache2/apache2.conf"

sudo service apache2 restart

}
