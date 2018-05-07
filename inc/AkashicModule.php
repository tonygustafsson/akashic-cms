<?php

class AkashicModule {
    public function __construct($akashic) {
        $this->akashic = $akashic;
    }

    public function get($matches) {
		$file = 'modules/' . $matches[1] . '.php';
			
		if (!file_exists($file)) {
			return 'Module "' . $file . '" does not exists.';
		}
		
		$newContent = $this->akashic->file->getContent($file);

		if (preg_match('/\[\[(.*)\]\]/i', $newContent)) {
			return $this->akashic->page->processPageLogic($newContent);
		}
		
		return $newContent;
	}
}