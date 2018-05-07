<?php

class AkashicModule {
    public function __construct($akashic) {
		$this->akashic = $akashic;
		$this->module_pattern = '/\[module: (.*)\]/i';
	}
	
	public function load($content) {
		/* Include modules by [[module]] */
		return preg_replace_callback($this->module_pattern, array($this, 'get'), $content);
	}

    public function get($matches) {
		$file = 'modules/' . $matches[1] . '.php';
			
		if (!file_exists($file)) {
			return 'Module "' . $file . '" does not exists.';
		}
		
		$newContent = $this->akashic->file->getContent($file);

		if (preg_match($this->module_pattern, $newContent)) {
			// Recusive get child modules
			return $this->load($newContent);
		}
		
		return $newContent;
	}
}