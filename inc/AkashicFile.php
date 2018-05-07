<?php

class AkashicFile {
    public function __construct($akashic) {
        $this->akashic = $akashic;
    }

	public function getContent($file) {
		ob_start();
		include($file);
		return ob_get_clean();
	}
}