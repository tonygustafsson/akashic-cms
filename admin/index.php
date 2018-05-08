<?php

require_once("../settings.php");

class AkashicAdmin {
    public function __construct() {
        $this->settings = new Settings();
		$this->url_path = str_replace($this->settings->site_path . 'admin/', '', $_SERVER['REQUEST_URI']);
		$this->url_segments = empty($this->url_path) ? array() : explode('/', $this->url_path);

        $this->html_top = '<html><head><title>Akashic CMS Admin</title>'
        . '	<link rel="stylesheet" type="text/css" media="all" href="styles.css">'
        . '</head><body>'
        . '<h1>Akashic CMS Admin</h1>';
        $this->html_bottom = '</body></html>';

        if (count($this->url_segments) == 0) {
            $this->list();
        }
        else if ($this->url_segments[0] == 'add_definition') {
            $this->add_definition();
        }
    }

    public function list() {
        echo $this->html_top;

        echo '<a href="add_definition">Add data definition</a>';

        echo $this->html_bottom;
    }

    public function add_definition() {
        echo $this->html_top;

        echo '<form action="' . $this->settings->site_path . 'admin/add_definition_post' . '">';
        echo '<label for="title">Title</label><input type="text" id="title" name="title" />';

        echo '<label for="description">Description</label><input type="text" id="description" name="description" />';

        echo '<label for="type">Type</label><select>'
        . '<option value="string">String</option>'
        . '<option value="number">Number</option>'
        . '<option value="enum">Enum</option>'
        . '<option value="bool">Boolean</option>';
        echo '</select>';

        echo '<label for="type">Form Type</label><select>'
        . '<option value="input">Input</option>'
        . '<option value="number">Number</option>'
        . '<option value="textarea">Textarea</option>'
        . '<option value="select">Select</option>'
        . '<option value="checkbox">Checkbox</option>';
        echo '</select>';

        echo '<label for="max_length">Max length</label><input type="number" value="255" name="max_length" id="max_length" />';
        
        echo '<label for="min_length">Min length</label><input type="number" value="0" name="min_length" id="min_length" />';

        echo '<label for="max_number">Max number</label><input type="number" value="0" name="max_number" id="max_number" />';

        echo '<label for="min_number">Min number</label><input type="number" value="0" name="min_number" id="min_number" />';

        echo '<label for="lang_dependent">Language dependent</label><input type="checkbox" name="lang_dependent" id="lang_dependent" />';

        echo '<label for="obligatory">Obligatory</label><input type="checkbox" name="obligatory" id="obligatory" />';

            echo '<button type="submit">Save</button>';
        echo '</form>';

        echo '<label for="sort_order">Sort order</label><input type="number" value="0" name="sort_order" id="sort_order" />';

        echo $this->html_bottom;
    }
}

$akashic_admin = new AkashicAdmin();
