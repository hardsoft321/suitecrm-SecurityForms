<?php
$db_defs['form_fields_lists'] = array(
    'table' => 'form_fields_lists',
    'module' => 'FormFieldsLists',
    'fields' => array(
        'name' => array (
            'name' => 'name',
        ),
        'description' => array (
            'name' => 'description',
        ),
        'list_type' => array (
            'name' => 'list_type',
        ),
        'parent_type' => array(
            'name'=>'parent_type',
        ),
        'parent_id' => array (
            'name' => 'parent_id',
            'type' => 'id',
            'table' => '',
            'relationship_role_column' => 'parent_type',
            'required' => 'false',
        ),
    ),
    'indices' => array(
        array('fields' => array('parent_type', 'parent_id', 'list_type')),
    ),
);

$db_defs['form_fields'] = array(
    'table' => 'form_fields',
    'module' => 'FormFields',
    'fields' => array(
        'name' => array (
            'name' => 'name',
        ),
        'description' => array (
            'name' => 'description',
        ),
        'list_id' => array (
            'name' => 'list_id',
            'type' => 'id',
            'table' => 'form_fields_lists',
            'required' => true,
        ),
    ),
    'indices' => array(
        array('fields'=>array('list_id', 'name')),
    ),
);
