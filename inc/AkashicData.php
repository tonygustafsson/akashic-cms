<?php

require_once("./inc/AkashicDataVars.php");
require_once("./inc/AkashicDataForeach.php");

class AkashicData {
    public function __construct($akashic) {
        $this->akashic = $akashic;
        $this->vars = new AkashicDataVars($akashic);
        $this->foreach = new AkashicDataForeach($akashic);
    }

	public function replace_data_vars($content = '', $data_store) {
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