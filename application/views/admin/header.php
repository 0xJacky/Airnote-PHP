<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>笺记 | 管理控制台</title>

    <link href="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/css/animate.css" rel="stylesheet">
    <link href="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/css/style.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                            <img alt="image" class="img-circle" src="//uozi.oss-cn-hangzhou.aliyuncs.com/avatar/default.png" style="width: 48px">
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?=$_SESSION['username'];?></strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="/admin/logout">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        笺
                    </div>
                </li>
                <?php foreach ($sidebars as $sidebar){ ?>
                    <li class="<?php if($sidebar['url'] == $method) { echo 'active'; }?>">
                        <a href="/admin/<?php echo $sidebar['url'];?>"><i class="fa <?php echo $sidebar['i'];?>"></i> <span class="nav-label"><?php echo $sidebar['label'];?></span> </a>
                    </li>
                <?php } ?>
            </ul>

        </div>
    </nav>
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="/admin/logout">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>