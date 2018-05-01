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
			$content = $this->getFileContent("pages/start.php");
			echo $this->processPageVars($content);
		}
		else if (file_exists("pages/" . $this->url_path . "/index.php")) {
			// Special page, index.php
			$content = $this->getFileContent("pages/" . $this->url_path . "/index.php");
			echo $this->processPageVars($content);				
		}
		else if (file_exists("pages/" . $this->url_path . ".php")) {
			// Special page, directly to php
			$content = $this->getFileContent("pages/" . $this->url_path . ".php");
			echo $this->processPageVars($content);	
		}
		else {
			$content = $this->getFileContent("pages/404.php");
			echo $this->processPageVars($content);
		}
	}

	private function getFileContent($file) {
		ob_start();
		include($file);
		return ob_get_clean();
	}

	private function getModule($matches) {
		$file = 'modules/' . $matches[1] . '.php';
			
		if (!file_exists($file)) {
			return 'Include "' . $file . '" does not exists.';
		}
		
		$newContent = $this->getFileContent($file);

		if (preg_match('/\[\[(.*)\]\]/i', $newContent)) {
			return $this->processPageVars($newContent);
		}
		
		return $newContent;
	}

	private function getTemplate($templateName) {
		$file = 'templates/' . $templateName . '.php';
			
		if (!file_exists($file)) {
			return 'Template "' . $file . '" does not exists.';
		}
		
		$newContent = $this->getFileContent($file);
		
		return $newContent;
	}
	
	private function processPageVars($content) {
		$includePattern = '/\[\[(.*)\]\]/i';
		$templatePattern = '/\@\{(.*)\}/i';

		$content = preg_replace_callback($includePattern, array($this, 'getModule'), $content);

		if (preg_match($templatePattern, $content)) {
			// Has template
			preg_match($templatePattern, $content, $matches);
			$templateName = $matches[1];
			$templateContent = $this->getTemplate($templateName);
			
			$content = str_replace("@{" . $templateName . "}", "", $content);
			$content = str_replace("@{content}", $content, $templateContent);
		}

		return $content;
	}
}

$akashic = new Akashic();
