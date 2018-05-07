<?php
require_once("settings.php");
require_once("./inc/AkashicFile.php");
require_once("./inc/AkashicPage.php");
require_once("./inc/AkashicModule.php");
require_once("./inc/AkashicTemplate.php");

class Akashic {
	public function __construct() {
		$this->settings = new Settings();
		$this->url_path = str_replace($this->settings->site_path, '', $_SERVER['REQUEST_URI']);
		$this->url_segments = empty($this->url_path) ? array() : explode('/', $this->url_path);

		$this->file = new AkashicFile($this);
		$this->page = new AkashicPage($this);
		$this->module = new AkashicModule($this);
		$this->template = new AkashicTemplate($this);

		$content = $this->page->get();
		echo $content;
	}
}
