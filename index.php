<?php
require_once("settings.php");

class Akashic {
	public $url_path;
	public $url_segments;
	public $settings;

	public function __construct() {
		$this->settings = new Settings();
		$this->url_path = str_replace($this->settings->site_path, '', $_SERVER['REQUEST_URI']);
		$this->url_segments = empty($this->url_path) ? array() : explode('/', $this->url_path);

		if (count($this->url_segments) == 0) {
			// Start page
			$content = $this->getFileContent("start.php");
			echo $this->processTemplateVars($content);
		}
		else if (file_exists($this->url_path . ".php")) {
			// Special page
			$content = $this->getFileContent($this->url_path . ".php");
			echo $this->processTemplateVars($content);	
		}
		else {
			$content = $this->getFileContent("404.php");
			echo $this->processTemplateVars($content);
		}
	}

	private function getFileContent($file) {
		ob_start();
		include($file);
		return ob_get_clean();
	}

	private function getTemplate($matches) {
		$file = $matches[1] . '.php';
			
		if (!file_exists($file)) {
			return 'Template "' . $file . '" does not exists.';
		}
		
		$newContent = $this->getFileContent($file);
		
		if (preg_match('/\[\[(.*)\]\]/i', $newContent)) {
			return $this->processTemplateVars($newContent);
		}
		
		return $newContent;
	}
	
	private function processTemplateVars($content) {
		$includePattern = '/\[\[(.*)\]\]/i';
		return preg_replace_callback($includePattern, array($this, 'getTemplate'), $content);
	}
}

$akashic = new Akashic();
