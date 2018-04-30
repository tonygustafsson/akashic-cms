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

	$content = getFileContent("start.php");

	echo processTemplateVars($content);
