<?php

require_once("./inc/AkashicData.php");

class AkashicDataVars extends AkashicData {
    public function __construct($akashic) {
        $this->akashic = $akashic;
		$this->data_store_pattern = '/\[data: (.*)\]/i';
    }

    public function load($content) {
		preg_match($this->data_store_pattern, $content, $data_store_matches);

        $data_store = array();
        $data_store_name = "";

		/* Define data store with ##datastore## */
		if (count($data_store_matches) > 0) {
			$data_store_name = $data_store_matches[1];
			$content = preg_replace($this->data_store_pattern, "", $content);
			$data_store_content = $this->akashic->file->getContent('data/' . $data_store_name . '.json');
			$data_store = json_decode($data_store_content);
        }
        
		/* Define data variables with ${variable} */
		echo $this->replace_data_vars($content, $data_store);
    }
}
