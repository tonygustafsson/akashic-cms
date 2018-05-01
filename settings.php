<?php

class Settings {
    public $site_path;

    public function __construct() {
        $this->site_path = '/akashic-cms/';
        $this->start_page = 'pages/start.php';
        $this->not_found_page = 'pages/404.php';
    }
}
