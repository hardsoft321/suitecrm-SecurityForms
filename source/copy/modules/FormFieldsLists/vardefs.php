<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['FormFieldsList'] = array(
    'table' => 'form_fields_lists',
    'unified_search' => true,
    'fields' => array (
        'list_type' => array (
            'name' => 'list_type',
            'vname' => 'LBL_TYPE',
            'type' => 'varchar',
            'len' => '50',
            'required' => false,
        ),
        'parent_type' => array(
            'name'=>'parent_type',
            'vname'=>'LBL_PARENT_NAME',
            'type' => 'parent_type',
            'dbType'=>'varchar',
            'group'=>'parent_name',
            'required'=>false,
            'len'=>'100',
            'comment' => 'The Sugar object to which the list is related',
        ),
        'parent_name' => array(
            'name'=> 'parent_name',
            'parent_type'=>'record_type_display',
            'type_name'=>'parent_type',
            'id_name'=>'parent_id',
            'vname'=>'LBL_LIST_RELATED_TO',
            'type'=>'parent',
            'group'=>'parent_name',
            'source'=>'non-db',
            'options' => 'fflist_parent_type_display',
        ),
        'parent_id' => array (
            'name' => 'parent_id',
            'type' => 'id',
            'group'=>'parent_name',
            'reportable'=>false,
            'vname'=>'LBL_PARENT_ID',//LBL_LIST_RELATED_TO_ID
        ),
        'fields' => array (
            'name' => 'fields',
            'type' => 'link',
            'relationship' => 'list_fields',
            'module'=>'FormFields',
            'bean_name'=>'FormField',
            'source'=>'non-db',
            'vname'=>'LBL_FIELDS',
        ),
    ),
    'relationships' => array(
        'list_fields' => array(
            'lhs_module'=> 'FormFieldsLists',
            'lhs_table'=> 'form_fields_lists',
            'lhs_key' => 'id',
            'rhs_module'=> 'FormFields',
            'rhs_table'=> 'form_fields',
            'rhs_key' => 'list_id',
            'relationship_type'=>'one-to-many',
        ),
    ),
);
$dictionary['FormFieldsList']['indices'][] = array('name'=>'idx_parent_d', 'type'=>'index', 'fields'=>array('parent_id', 'parent_type', 'deleted'));
$dictionary['FormFieldsList']['indices'][] = array('name'=>'idx_parent_type_d', 'type'=>'index', 'fields'=>array('parent_id', 'parent_type', 'list_type', 'deleted'));

VardefManager::createVardef('FormFieldsLists', 'FormFieldsList', array('default'));
?>
