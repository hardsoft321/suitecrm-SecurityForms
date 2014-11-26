<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['FormFieldsScenario'] = array(
    'table' => 'form_fields_scenarios',
    'unified_search' => true,
    'fields' => array (
        'uniq_name' => array (
            'name' => 'uniq_name',
            'vname' => 'LBL_UNIQ_NAME',
            'type' => 'varchar',
            'len' => '50',
            'required' => true,
        ),
        'sf_module' => array (
            'name' => 'sf_module',
            'vname' => 'LBL_MODULE',
            'type' => 'varchar',
            //'type' => 'enum',
            //'function' => 'sf_getModulesList',
            'len' => '100',
            'required' => true,
        ),
    ),
);
$dictionary['FormFieldsScenario']['indices'][] = array('name'=>'idx_mod_uniq_d', 'type'=>'index', 'fields'=>array('sf_module', 'uniq_name', 'deleted'));

VardefManager::createVardef('FormFieldsScenarios', 'FormFieldsScenario', array('default'));
?>
