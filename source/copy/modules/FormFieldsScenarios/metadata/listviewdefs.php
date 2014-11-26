<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$listViewDefs['FormFieldsScenarios'] = array(
  'NAME' => array(
    'width' => '40', 
    'label' => 'LBL_LIST_NAME', 
    'link' => true,
    'default' => true,
  ),
  'UNIQ_NAME' => array(
    'width' => '40',
    'label' => 'LBL_LIST_UNIQ_NAME',
    'link' => false,
    'default' => true,
  ),
  'SF_MODULE' => array(
    'width' => '40',
    'label' => 'LBL_LIST_MODULE',
    'link' => false,
    'default' => true,
  ),
);
?>
