<?php

class AkashicTemplate {
    public function __construct($akashic) {
		$this->akashic = $akashic;
		$this->template_pattern = '/\@\{(.*)\}/i';
    }

	public function load($content) {
		/* Define template with @{template} and the content inside template with ${content} */
		preg_match($this->template_pattern, $content, $template_matches);

		if (count($template_matches) > 0) {
			// Has template, include content inside template
			$templateName = $template_matches[1];
			$templateContent = $this->get($templateName);
			
			$content = str_replace("@{" . $templateName . "}", "", $content);
			$content = str_replace("@{content}", $content, $templateContent);
		}

		return $content;
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