<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['FormField'] = array(
    'table' => 'form_fields',
    'unified_search' => true,
    'fields' => array (
        'list_id' => array (
            'name' => 'list_id',
            'vname' => 'LBL_LIST',
            'type' => 'id',
            'required' => true,
        ),
        'list_name' => array (
            'name' => 'list_name',
            'rname' => 'name',
            'id_name' => 'list_id',
            'vname' => 'LBL_LIST',
            'type' => 'relate',
            'table' => 'form_fields_lists',
            'module' => 'FormFieldsLists',
            'source' => 'non-db',
            'required' => true,
        ),
    ),
);
$dictionary["FormField"]['indices'][] = array('name'=>'idx_list_d', 'type'=>'index', 'fields'=>array('list_id', 'deleted'));

VardefManager::createVardef('FormFields', 'FormField', array('default'));
?>
