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
$THEME_name       =$_POST['THEME_list'];
//$SITE_index       =$_POST['SITE_index'];

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

wp plugin delete hello akismet  

wp plugin install duplicator wordfence duplicate-post wordpress-seo contact-form-7 --activate

wp theme install '.$THEME_name.' --activate

wp theme delete twentyfifteen twentysixteen twentyseventeen


sudo sed -i -e \'12,17d\' /etc/apache2/sites-available/000-default.conf

sudo sed -i "12i\DocumentRoot /var/www/html/'.$SITE_title.'\n<Directory /var/www/html/'.$SITE_title.'>\nOptions Indexes FollowSymlinks\nAllowOverride All\nRequire all granted\n</Directory>\n" /etc/apache2/sites-available/000-default.conf

sudo service apache2 reload';

//echo $cmd;
//echo '1 :'.escapeshellcmd($cmd);
//echo '  <br>  2 :'.escapeshellarg($cmd);

exec($cmd);
//exec($cmd,$output,$return_var);

?>

<!--sudo sed -i -e "\$a<ifModule mod_rewrite.c>\nRewriteEngine On\n</ifModule>" /etc/apache2/apache2.conf-->
