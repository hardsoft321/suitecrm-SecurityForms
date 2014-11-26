<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings;

$popupMeta = array('moduleMain' => 'FormField',
    'varName' => 'FORMFIELDSSCENARIO',
    'orderBy' => 'scenario',
    'searchInputs' =>
        array('sf_module','uniq_name', 'name'),
    'listviewdefs' => array(
        'NAME' => array (
            'width'   => '30',  
            'label'   => 'LBL_NAME', 
            'link'    => true,
            'default' => true
        ),
        'SF_MODULE' => array (
            'width'   => '30',  
            'label'   => 'LBL_MODULE', 
            'link'    => true,
            'default' => true
        ),
        'UNIQ_NAME' => array (
            'width'   => '30',  
            'label'   => 'LBL_UNIQ_NAME', 
            'link'    => true,
            'default' => true
        ),
        
    ),
    'searchdefs'   => array(
        'name', 'sf_module', 'uniq_name'
    )
);
?>
