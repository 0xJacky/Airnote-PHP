<?php
/**
* 笺记 API 自动加载整体框架
* Copyright 2017 0xJacky
**/
ini_set('date.timezone','Asia/Shanghai');
ini_set('memory_limit', '-1');
/* 取得根目录 */
define('ROOT_PATH', str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__)));

/* 初始化数据库类 */
require(ROOT_PATH . 'includes/cls_mysqli.php');
require(ROOT_PATH . 'config.php');

$db = new cls_mysqli($db_host, $db_user, $db_pw, $db_name);
$db_host = $db_user = $db_pw = $db_name = NULL;

/* 初始化密钥连接公用类库 */
require(ROOT_PATH . 'includes/cls_auth.php');
$auth = new cls_auth();

/* 初始化操作结果返回公用类库 */
require(ROOT_PATH . 'includes/cls_result.php');
$result = new cls_result();

/* 初始化 User 公用类库 */
require(ROOT_PATH . 'includes/cls_user.php');
$user = new cls_user();

/* 初始化文章公用类库 */
require(ROOT_PATH . 'includes/cls_post.php');
$post = new cls_post();

/* 初始化辅助函数公用类库 */
require(ROOT_PATH . 'includes/cls_functions.php');
$helper = new cls_functions();
?>
