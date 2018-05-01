<?php
	function getFileContent($file) {
		ob_start();
		include($file);
		return ob_get_clean();
	}

	function getTemplate($matches) {
		$file = $matches[1] . '.php';
			
		if (!file_exists($file)) {
			return 'Template "' . $file . '" does not exists.';
		}
		
		$newContent = getFileContent($file);
		
		if (preg_match('/\[\[(.*)\]\]/i', $newContent)) {
			return processTemplateVars($newContent);
		}
		
		return $newContent;
	}
	
	function processTemplateVars($content) {
		$includePattern = '/\[\[(.*)\]\]/i';
		return preg_replace_callback($includePattern, 'getTemplate', $content);
	}

	$site_path = '/akashic-cms/';
	$url_path = str_replace($site_path, '', $_SERVER['REQUEST_URI']);
	$url_segments = empty($url_path) ? array() : explode('/', $url_path);

	if (count($url_segments) == 0) {
		// Start page
		$content = getFileContent("start.php");
		echo processTemplateVars($content);
	}
	else if (file_exists($url_path . ".php")) {
		// Special page
		$content = getFileContent($url_path . ".php");
		echo processTemplateVars($content);	
	}
	else {
		$content = getFileContent("404.php");
		echo processTemplateVars($content);
	}