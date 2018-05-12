<?php

function getContent($file) {
    ob_start();
    include($file);
    return ob_get_clean();
}

function getFieldFromSchema($lookForField, $schema) {
    foreach ($schema->fieldsets as $fieldset) {
        $fields = $fieldset->fields;

        foreach ($fields as $field_name => $field) {
            if ($field_name == $lookForField) {
                return $field;
                break 2;
            }
        }
    }
}

$schema = json_decode(getContent('../schemas/product.json'));

$error = false;
$error_message = "";

foreach ($_POST as $post_field_name => $post_value) {
    $post_field_name = str_replace("akashic-", "", $post_field_name);
    $schema_field = getFieldFromSchema($post_field_name, $schema);
    
    if (isset($schema_field->required) && $schema_field->required && (!$post_value || empty($post_value))) {
        $error = true;
        $error_message .= '"' . $schema_field->title . '" is required.<br />';
    }

    if (isset($schema_field->minLength) && strlen($post_value) < $schema_field->minLength) {
        $error = true;
        $error_message .= '"' . $schema_field->title . '" cannot be any less than ' . $schema_field->minLength . ' characters long.<br />';
    }

    if (isset($schema_field->maxLength) && strlen($post_value) > $schema_field->maxLength) {
        $error = true;
        $error_message .= '"' . $schema_field->title . '" cannot be any longer than ' . $schema_field->maxLength . ' characters long.<br />';
    }

    if (isset($schema_field->minValue) && (!is_numeric($post_value) || $post_value < $schema_field->minValue)) {
        $error = true;
        $error_message .= '"' . $schema_field->title . '" cannot be any less than ' . $schema_field->minValue . '.<br />';
    }

    if (isset($schema_field->maxValue) && (!is_numeric($post_value) || $post_value > $schema_field->maxValue)) {
        $error = true;
        $error_message .= '"' . $schema_field->title . '" cannot be any highter than ' . $schema_field->maxValue . '.<br />';
    }
}

if ($error) {
    $json_content = json_encode(['error' => true, 'error_message' => $error_message]);
}
else {
    $json_content = json_encode(['error' => false]);
}

echo $json_content;
