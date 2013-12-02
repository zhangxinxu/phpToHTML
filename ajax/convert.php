<?php
	session_start();
	if ($_SESSION['agent'] && $_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) {
		$dir = $_POST['dir'];
		$url = $_POST['url'];
		$level = $_POST['level'];
		$filename = $_POST['filename'];
		if (isset($dir) && isset($filename)) {
			$arr_filename = explode(",", $filename);
			while (list($key, $val) = each($arr_filename)) {
  				$content = file_get_contents($url.'/'.$val);
				$content = str_replace('.php', '.html', $content);
				
				if ($level == '1') {				
					$content = str_replace('"../', '"../../', $content);
					$content = str_replace('"./', '"../', $content);
					if (is_dir($dir.'\\_html') == false) {
						mkdir($dir.'\\_html');
					}
					$address = $dir.'\\_html\\'.str_replace('.php', '.html', $val);
				} else if ($level = '-1') {
					$content = str_replace('"../', '"', $content);
					$dirSplit = explode('\\', $dir);
					// 删除最后一个层级，获得父目录路径
					array_pop($dirSplit);
					$address = implode('\\', $dirSplit).'\\'.str_replace('.php', '.html', $val);
				} else {
					$address = $dir.str_replace('.php', '.html', $val);
				}

				file_put_contents($address, $content);
 			}
			if (isset($arr_errorname) && is_array($arr_errorname)) {
				echo '{"succ": false, "data": [' .implode(',', $arr_errorname). ']}';
			} else {
				echo '{"succ": true, "data": []}';
			}
		} else {
			echo '{"succ": false, "msg": "参数提交有误！"}';	
		}
	}
?>
