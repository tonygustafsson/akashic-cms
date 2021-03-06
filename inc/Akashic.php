<?php
require_once("settings.php");
require_once("./inc/AkashicFile.php");
require_once("./inc/AkashicModule.php");
require_once("./inc/AkashicLink.php");
require_once("./inc/AkashicTemplate.php");
require_once("./inc/AkashicData.php");

class Akashic {
	public function __construct() {
		$this->settings = new Settings();
		$this->url_path = str_replace($this->settings->site_path, '', $_SERVER['REQUEST_URI']);
		$this->url_segments = empty($this->url_path) ? array() : explode('/', $this->url_path);

		$this->file = new AkashicFile($this);
		$this->module = new AkashicModule($this);
		$this->link = new AkashicLink($this);
		$this->template = new AkashicTemplate($this);
		$this->data = new AkashicData($this);

		if (count($this->url_segments) == 0) {
			// Start page
			$content = $this->file->getContent($this->settings->start_page);
		}
		else if (file_exists("pages/" . $this->url_path . "/index.php")) {
			// Special page, index.php
			$content = $this->file->getContent("pages/" . $this->url_path . "/index.php");
		}
		else if (file_exists("pages/" . $this->url_path . ".php")) {
			// Special page, directly to php
			$content = $this->file->getContent("pages/" . $this->url_path . ".php");
		}
		else {
			$content = $this->file->getContent($this->settings->not_found_page);
		}

		$content = $this->template->load($content);
		$content = $this->module->load($content);
		$content = $this->link->load($content);
		$content = $this->data->foreach->load($content);
		$content = $this->data->vars->load($content);
	}
}
