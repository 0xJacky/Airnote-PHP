<?php
define('IN_JianJi', true);
require('./includes/init.php');

echo '<br />register_name: test4<br />';
echo 'pw: '.md5('ilovephp233333').'<br />';
echo 'mail: test4@uozi.org<br />';
$user_token = $auth->generate_token(6);
echo $user_token;
echo '<br />';

?>
