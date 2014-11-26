<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['FormField'] = array(
    'table' => 'form_fields',
    'unified_search' => true,
    'fields' => array (
        'sf_module' => array (
            'name' => 'sf_module',
            'vname' => 'LBL_MODULE',
            'type' => 'varchar',
            //'type' => 'enum',
            //'function' => 'sf_getModulesList',
            'len' => '100',
            'required' => true,
        ),
        'scenario_id' => array (
            'name' => 'scenario_id',
            'vname' => 'LBL_SCENARIO',
            'type' => 'id',
            'required' => true,
        ),
        'scenario_name' => array (
            'name' => 'scenario_name',
            'rname' => 'name',
            'id_name' => 'scenario_id',
            'vname' => 'LBL_SCENARIO',
            'type' => 'relate',
            'table' => 'form_fields_scenarios',
            'module' => 'FormFieldsScenarios',
            'source' => 'non-db',
            'required' => true,
        ),
    ),
);
$dictionary["FormField"]['indices'][] = array('name'=>'idx_sc_d', 'type'=>'index', 'fields'=>array('scenario_id', 'deleted'));
$dictionary["FormField"]['indices'][] = array('name'=>'idx_mod_sc_d', 'type'=>'index', 'fields'=>array('sf_module', 'scenario_id', 'deleted'));

VardefManager::createVardef('FormFields', 'FormField', array('default'));
?>
