<?php
	session_start();
	if ($_SESSION['agent'] && $_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT'])) {
		$dir = $_POST['dir'];
		$url = $_POST['url'];
		$filename = $_POST['filename'];
		if (isset($dir) && isset($filename)) {
			$arr_filename = explode(",", $filename);
			while (list($key, $val) = each($arr_filename)) {
  				$content = file_get_contents($url.'/'.$val);
				$content = str_replace('.php', '.html', $content);
				$content = str_replace('"../', '"../../', $content);
				$content = str_replace('"./', '"../', $content);
				
				if (is_dir($dir.'\\_html') == false) {
					mkdir($dir.'\\_html');
				}
				
				$fp = fopen ($dir.'\\_html\\'.str_replace('.php', '.html', $val), "w");  
				if (fwrite ($fp, $content)){  
					fclose ($fp);
				} else {  
					fclose ($fp);  
					$arr_errorname[] = '"' .$val. '"';
				}  
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
