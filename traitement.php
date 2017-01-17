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


$cmd='sudo curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar';
exec($cmd,$output);

$cmd='chmod +x wp-cli.phar';
exec($cmd,$output);

$cmd='sudo mv wp-cli.phar /usr/local/bin/wp';
exec($cmd,$output);


$cmd='cd /var/www/html';
exec($cmd,$output);

$cmd='mkdir '.$SITE_title;
exec($cmd,$output);

$cmd='cd '.$SITE_title;
exec($cmd,$output);


$cmd='wp core download';
exec($cmd,$output);


$cmd='wp core config --dbname='.$BDD_name.' --dbuser='.$BDD_id.' --dbpass='.$BDD_mdp.' --locale=en_EN';
exec($cmd,$output);

$cmd='wp db create';
exec($cmd,$output);


$cmd='wp core install --url='.$BDD_host.' --title='.$SITE_title.' --admin_user='.$SITE_id.' --admin_password='.$SITE_mdp.' --admin_email='.$SITE_mail.' --skip-email';
exec($cmd,$output);




$cmd='sudo sed -i \'13i\<Directory /var/www/html/'.$SITE_title.'> Options Indexes FollowSymlinks AllowOverride All Require all granted </Directory>\' \'/etc/apache2/sites-available/000-default.conf\' ';
exec($cmd,$output);


$cmd='sudo su';
exec($cmd,$output);


$cmd='echo \'<ifModule mod_rewrite.c> RewriteEngine On </ifModule>\' >> /etc/apache2/apache2.conf';
exec($cmd,$output);


$cmd='sudo service apache2 restart';
exec($cmd,$output);

var_dump($output);

//echo $cmd;
//echo '1 :'.escapeshellcmd($cmd);
//echo '  <br>  2 :'.escapeshellarg($cmd);


//
//  if ($return_var!=0) {
//    echo(' ERREUR !! ');
//  }
?>
