<?php
/**
 * Cell - High performance framework
 * Copyright (C) 2017 0xJacky <jacky-943572677@qq.com>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 **/

defined('BASE_PATH') OR exit('No direct script access allowed');

/* Define App Version */
define('APP_VERSION', '2.1');

/* Default Timezone */
ini_set('date.timezone', 'Asia/Shanghai');

/* Root Path */
define('ROOT_PATH', dirname(dirname(__FILE__)));

/* Cell Libraries Path */
define('CORE_PATH', ROOT_PATH . '/core/');

/* System Path */
define('SYSTEM_PATH', ROOT_PATH. '/system/');

/* App Path */
define('APP_PATH', ROOT_PATH . '/app');

/* App Model Path */
define('M_PATH', APP_PATH . '/model/');

/* Airnote View Path */
define('V_PATH', APP_PATH . '/view/');

/* Airnote Controller Path */
define('C_PATH', APP_PATH . '/controller/');

/* base url define */
$sitepath = dirname(dirname($_SERVER['PHP_SELF']));
$sitepath = strlen($sitepath) === 1 ? '/' : $sitepath . '/';
$siteurl = htmlspecialchars(($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $sitepath);
define('SITE_URL', $siteurl);

/* 数据库地址 */
define('DB_HOST', 'localhost');

/* 数据库用户名 */
define('DB_USER', '');

/* 数据库密码 */
define('DB_PW', '');

/* 数据库名称 */
define('DB_NAME', '');

/* 后端密钥 */
define('SALT', '');

/* DEBUG 模式 */
define('IN_DEBUG', true);
