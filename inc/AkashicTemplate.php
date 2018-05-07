<?php

class AkashicTemplate {
    public function __construct($akashic) {
		$this->akashic = $akashic;
		$this->template_pattern = '/\[template: (.*)\]/i';
		$this->content_pattern = '/\[content\]/i';
    }

	public function load($content) {
		/* Define template with @{template} and the content inside template with ${content} */
		preg_match($this->template_pattern, $content, $template_matches);

		if (count($template_matches) > 0) {
			// Has template, include content inside template
			$templateName = $template_matches[1];
			$templateContent = $this->get($templateName);
			
			$content = preg_replace($this->template_pattern, "", $content);
			$content = preg_replace($this->content_pattern, $content, $templateContent);
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
