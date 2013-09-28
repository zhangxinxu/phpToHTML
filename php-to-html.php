<?php
	session_start();
	$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="description" content="把本地某文件夹下的所有php文件转换成HTML格式，方便产品经理的浏览 » 张鑫旭-鑫空间-鑫生活" />
<meta name="description" content="把本地某文件夹下的所有php文件转换成HTML格式" />
<meta name="keywords" content="php, html, 工具" />
<meta name="author" content="张鑫旭, zhangxinxu" />
<title>批量转HTML页面</title>
<link rel="stylesheet" href="http://www.zhangxinxu.com/study/css/zxx.lib.css">
<link rel="stylesheet" href="php-to-html.css">
</head>

<body>
<span id="error" class="error"></span>
<h1 class="tc fw">PHP批量转HTML页面</h1>
<div class="list" data-index="1">
    <form id="formFilelist" action="ajax/filelist.php" method="get">
        <p><label for="inputDir">请输入文件夹目录：</label></p>
        <p><input type="search" id="inputDir" class="p5 pct90" name="dir" placeholder="回车确认，如D:\myfile" required autocomplete="on"></p>
         
    </form>
</div>
<div id="fileList" class="list dn" data-index="2">
	<form id="formConvert" action="ajax/convert.php" method="post">
    	<p><label for="inputUrl">请输入URL根路径：</label></p>
        <p><input type="url" id="inputUrl" class="p5 pct90" name="url" placeholder="如http://localhost/myfile/" required autocomplete="on"></p>
    	<ul id="nameList" class="namelist"></ul>
        <p><input type="submit" class="button" value="开始转换"></p>
    </form>
</div>

<div id="succList" class="list dn" data-index="3">
	转换成功！点击<a href="" id="previewLink">这里</a>查看！
</div>

<script src="http://libs.baidu.com/jquery/1.4.4/jquery.min.js"></script>
<script src="php-to-html.js"></script>
</body>
</html>