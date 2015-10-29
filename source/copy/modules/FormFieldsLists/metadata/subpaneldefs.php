<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$layout_defs['FormFieldsLists'] = array(
    'subpanel_setup' => array(
        'fields' => array(
            'order' => 10,
            'sort_by' => 'name',
            'sort_order' => 'asc',
            'module' => 'FormFields',
            'refresh_page' => 0,
            'subpanel_name' => 'default',
            'get_subpanel_data' => 'fields',
            'title_key' => 'LBL_FIELDS_SUBPANEL_TITLE',
        ),
    ),
);
