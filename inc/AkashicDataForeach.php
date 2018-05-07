<?php

require_once("./inc/AkashicData.php");

class AkashicDataForeach extends AkashicData {
    public function __construct($akashic) {
        $this->akashic = $akashic;
        $this->foreach_pattern = '/\[foreach \$\{(.*)\}:(?:\r|\n)+(.*)(?:\r|\n)+\]/s';
    }

    public function load($content) {
        $data_store = "";

		/* Define foreaches with [foreach data: <html>] */
		preg_match_all($this->foreach_pattern, $content, $foreach_matches);

		if (count($foreach_matches[1]) > 0 && count($foreach_matches[2])) {
			$data = trim($foreach_matches[1][0]);
			$html = trim($foreach_matches[2][0]);
			$new_html = "";

			$foreach_data_store_content = $this->akashic->file->getContent('data/' . $data . '.json');
			$foreach_data_store = json_decode($foreach_data_store_content);

			foreach ($foreach_data_store as $this_data_store) {
				$new_html .= $this->replace_data_vars($html, $this_data_store);
			}

			$content = preg_replace($this->foreach_pattern, $new_html, $content);
		}

		/* Define data variables with ${variable} */
		return $this->replace_data_vars($content, $data_store);
    }
}
