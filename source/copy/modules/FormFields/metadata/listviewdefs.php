<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$listViewDefs['FormFields'] = array(
  'NAME' => array(
    'width' => '40', 
    'label' => 'LBL_LIST_NAME', 
    'link' => true,
    'default' => true,
  ),
  'SCENARIO_ID' => array(
    'width' => '40',
    'label' => 'LBL_LIST_SCENARIO',
    'link' => true,
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
