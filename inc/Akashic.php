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

		$content = $this->getPage();
		echo $content;
	}

	private function getPage() {
		if (count($this->url_segments) == 0) {
			// Start page
			$content = $this->getFileContent($this->settings->start_page);
			return $this->processPageVars($content);
		}
		else if (file_exists("pages/" . $this->url_path . "/index.php")) {
			// Special page, index.php
			$content = $this->getFileContent("pages/" . $this->url_path . "/index.php");
			return $this->processPageVars($content);				
		}
		else if (file_exists("pages/" . $this->url_path . ".php")) {
			// Special page, directly to php
			$content = $this->getFileContent("pages/" . $this->url_path . ".php");
			return $this->processPageVars($content);	
		}
		else {
			$content = $this->getFileContent($this->settings->not_found_page);
			return $this->processPageVars($content);
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
		$include_pattern = '/\[\[(.*)\]\]/i';
		$template_pattern = '/\@\{(.*)\}/i';
		$data_store_pattern = '/\#\#(.*)\#\#/i';
		$data_variable_pattern = '/\$\{(.*)\}/i';

		$content = preg_replace_callback($include_pattern, array($this, 'getModule'), $content);

		preg_match($data_store_pattern, $content, $data_store_matches);

		if (count($data_store_matches) > 0) {
			$data_store_name = $data_store_matches[1];
			$content = str_replace("##" . $data_store_name . "##", "", $content);
			$data_store_content = $this->getFileContent('data/' . $data_store_name . '.json');
			$data_store = json_decode($data_store_content);
		}

		preg_match_all($data_variable_pattern, $content, $data_vars_matches);

		if (count($data_vars_matches) > 0) {
			$data = $data_vars_matches[1];

			foreach ($data as $var) {
				$content = str_replace("\${" . $var . "}", $data_store->$var, $content);
			}
		}

		preg_match($template_pattern, $content, $template_matches);

		if (count($template_matches) > 0) {
			// Has template, include content inside template
			$templateName = $template_matches[1];
			$templateContent = $this->getTemplate($templateName);
			
			$content = str_replace("@{" . $templateName . "}", "", $content);
			$content = str_replace("@{content}", $content, $templateContent);
		}

		return $content;
	}
}
