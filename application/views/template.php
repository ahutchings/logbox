<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <title><?php if (isset($title)): ?><?php echo $title ?> - <?php endif ?>Logbox</title>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css">
    <link rel="stylesheet" type="text/css" href="/css/yuiapp.css">
    <link rel="stylesheet" type="text/css" href="/css/theme.css" id="theme">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>
    <script src="/scripts/theme.js" type="text/javascript"></script>
    <!--[if IE]><script type="text/javascript" src="/scripts/excanvas.compiled.js"></script><![endif]-->
    <script src="/scripts/jquery.flot.pack.js" type="text/javascript"></script>
</head>
<body class="">
    <div id="doc3" class="yui-t6">

        <div id="hd">
            <h1><a href="/">Logbox</a></h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li class="active"><a href="/">Messages</a></li>
                    <li><a href="/message/statistics">Statistics</a></li>
                    <li><a href="/repository">Repositories</a></li>
                </ul>

                <ul id="user-navigation">
                    <li><a href="/user">Users</a></li>
                    <li><a href="/logout">Logout</a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>

        <div id="bd">
			<?php if ($message = Session::instance()->get_once('message')): ?>
			<div class="message <?php echo $message['type'] ?>">
			    <h4><?php echo $message['text'] ?></h4>
			</div>
			<?php endif ?>
	
			<?php echo $content; ?>
		</div>

		<div id="ft">
            <p class="inner">Copyright &copy; <?php echo date('Y') ?> Logbox</p>
        </div>

    </div>
</body>
</html>