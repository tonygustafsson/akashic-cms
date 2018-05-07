<?php

class AkashicPage {
    public function __construct($akashic) {
        $this->akashic = $akashic;
    }
    
	public function processPageLogic($content) {
		$data_store_pattern = '/\#\#(.*)\#\#/i';
		$foreach_pattern = '/\[foreach \$\{(.*)\}:(?:\r|\n)+(.*)(?:\r|\n)+\]/s';
		
		$data_store_name = "";
		$data_store = array();

		preg_match($data_store_pattern, $content, $data_store_matches);

		/* Define data store with ##datastore## */
		if (count($data_store_matches) > 0) {
			$data_store_name = $data_store_matches[1];
			$content = str_replace("##" . $data_store_name . "##", "", $content);
			$data_store_content = $this->akashic->file->getContent('data/' . $data_store_name . '.json');
			$data_store = json_decode($data_store_content);
		}

		/* Define foreaches with [foreach data: <html>] */
		preg_match_all($foreach_pattern, $content, $foreach_matches);

		if (count($foreach_matches[1]) > 0 && count($foreach_matches[2])) {
			$data = trim($foreach_matches[1][0]);
			$html = trim($foreach_matches[2][0]);
			$new_html = "";

			$foreach_data_store_content = $this->akashic->file->getContent('data/' . $data . '.json');
			$foreach_data_store = json_decode($foreach_data_store_content);

			foreach ($foreach_data_store as $this_data_store) {
				$new_html .= $this->replace_data_vars($html, $this_data_store);
			}

			$content = preg_replace($foreach_pattern, $new_html, $content);
		}

		/* Define data variables with ${variable} */
		$content = $this->replace_data_vars($content, $data_store);

		return $content;
	}

	private function replace_data_vars($content = '', $data_store) {
		/* Define data variables with ${variable} */
		$data_variable_pattern = '/\$\{([a-z0-9]+)\}/i';

		preg_match_all($data_variable_pattern, $content, $data_vars_matches);

		if (count($data_vars_matches) > 0) {
			$data_vars = $data_vars_matches[1];

			foreach ($data_vars as $data_var) {
				if (!isset($data_store->$data_var)) {
					continue;
				}

				$data_store_val = $data_store->$data_var;

				if (is_array($data_store_val)) {
					$array_content = "";

					foreach ($data_store_val as $data_item) {
						$array_content .= $data_item->name;
					}

					$content = str_replace("\${" . $data_var . "}", $array_content, $content);
				}
				else {
					$content = str_replace("\${" . $data_var . "}", $data_store_val, $content);
				}
			}
		}

		return $content;
	}
}