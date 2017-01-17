<?php

$BDD_name         =$_POST['BDD_name'];
$BDD_id           =$_POST['BDD_id'];
$BDD_mdp          =$_POST['BDD_mdp'];
$BDD_host         =$_POST['BDD_host'];
$BDD_prefixe      =$_POST['BDD_prefixe'];
$SITE_title       =$_POST['SITE_title'];
$SITE_id          =$_POST['SITE_id'];
$SITE_mdp         =$_POST['SITE_mdp'];
$SITE_mdp_confirm =$_POST['SITE_mdp_confirm'];
$SITE_mail        =$_POST['SITE_mail'];
//$SITE_index       =$_POST['SITE_index'];

$textToAdd = "<Directory /var/www/html/wpcli>
              Options Indexes FollowSymlinks
              AllowOverride All
              Require all granted
              </Directory>";

$textConf = "<ifModule mod_rewrite.c>
              RewriteEngine On
              </ifModule>";

$output= array();
$cmd='sudo curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp

cd /var/www/html
mkdir '.$SITE_title.'
cd '.$SITE_title.'

wp core download

wp core config --dbname='.$BDD_name.' --dbuser='.$BDD_id.' --dbpass='.$BDD_mdp.' --locale=en_EN

wp db create

wp core install --url='.$BDD_host.' --title='.$SITE_title.' --admin_user='.$SITE_id.' --admin_password='.$SITE_mdp.' --admin_email='.$SITE_mail.' --skip-email



sudo sed -i \'13i\<Directory /var/www/html/wpcli>
              Options Indexes FollowSymlinks
              AllowOverride All
              Require all granted
              </Directory>\' \'/etc/apache2/sites-available/000-default.conf\'

\'<ifModule mod_rewrite.c>
RewriteEngine On
</ifModule>\' >> \'/etc/apache2/apache2.conf\'

sudo service apache2 restart';

$return_var=10;
//echo $cmd;
//echo '1 :'.escapeshellcmd($cmd);
//echo '  <br>  2 :'.escapeshellarg($cmd);

$test = exec($cmd);
//exec($cmd,$output,$return_var);

var_dump($test);

 if ($return_var!=0) {
   echo(' ERREUR !! ');
 }
?>
