<?php
	session_start();
	if ($_SESSION['agent'] && $_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) {
		$dir = $_GET['dir'];	
		if (isset($dir)) {
			// open
			$fp = opendir($dir);
			// read
			while( ($file = readdir($fp)) !== false ) {
				// there are must be two files with the name '.' and  '..', escape them;
				if($file != '.' && $file != '..' && preg_match('/\.php$/i', $file)) {
					// to array
					$arr_file[] = '"'.$file.'"';
				}
			}
			// close
			closedir($fp);
			// input
			if (is_array($arr_file)) {
				echo '{"succ": true, "data": [' .implode(',', $arr_file). ']}';
			} else {
				echo '{"succ": false, "msg": "文件获取异常！"}';
			}
		} else {
			echo '{"succ": false, "msg": "参数提交有误！"}';	
		}
	}
?>
