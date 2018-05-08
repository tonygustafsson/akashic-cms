<?php

class AkashicLink {
    public function __construct($akashic) {
		$this->akashic = $akashic;
		$this->link_pattern = '/\[link: (.*)\]/i';
	}
	
	public function load($content) {
		/* Include modules by [[module]] */
		return preg_replace_callback($this->link_pattern, array($this, 'get'), $content);
	}

    public function get($matches) {
		$url = $matches[1];

		return $this->akashic->settings->site_path . $url;
	}
}