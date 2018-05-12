<?php

function getContent($file) {
    ob_start();
    include($file);
    return ob_get_clean();
}

$schema = json_decode(getContent('../schemas/product.json'));

echo '<pre>'; print_r($schema); print_r($_POST);