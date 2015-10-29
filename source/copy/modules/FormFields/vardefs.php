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
            'link' => 'list_link',
            'table' => 'form_fields_lists',
            'module' => 'FormFieldsLists',
            'source' => 'non-db',
            'required' => true,
        ),
        'list_link' => array(
            'name' => 'list_link',
            'type' => 'link',
            'relationship' => 'fflist_fields',
            'source'=>'non-db',
            'vname'=>'LBL_LIST',
        ),
    ),
    'relationships' => array (
        'fflist_fields' => array(
            'lhs_module' => 'FormFieldsLists',
            'lhs_table' => 'form_fields_lists',
            'lhs_key' => 'id',
            'rhs_module' => 'FormFields',
            'rhs_table' => 'form_fields',
            'rhs_key' => 'list_id',
            'relationship_type' => 'one-to-many',
        ),
    ),
);
$dictionary["FormField"]['indices'][] = array('name'=>'idx_list_d', 'type'=>'index', 'fields'=>array('list_id', 'deleted'));

VardefManager::createVardef('FormFields', 'FormField', array('default'));
?>
