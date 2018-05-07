<?php

class AkashicTemplate {
    public function __construct($akashic) {
        $this->akashic = $akashic;
    }

	public function get($templateName) {
		$file = 'templates/' . $templateName . '.php';
			
		if (!file_exists($file)) {
			return 'Template "' . $file . '" does not exists.';
		}
		
		$newContent = $this->akashic->file->getContent($file);
		
		return $newContent;
	}
}