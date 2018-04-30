<?php
	function getTemplate($matches) {
		$file = $matches[1] . '.php';
			
		if (!file_exists($file)) {
			return 'Template "' . $file . '" does not exists.';
		}
		
		ob_start();
		include($file);
		$newContent = ob_get_clean();
		
		if (preg_match('/\[\[(.*)\]\]/i', $newContent)) {
			return processTemplateVars($newContent);
		}
		
		return $newContent;
	}
	
	function processTemplateVars($content) {
		$includePattern = '/\[\[(.*)\]\]/i';
		return preg_replace_callback($includePattern, 'getTemplate', $content);
	}
?>

<?php
	$content = '
		<h1>SapCMS</h1>
		[[books]]
		
		<p>End of file</p>
	';

	echo processTemplateVars($content);
?>
