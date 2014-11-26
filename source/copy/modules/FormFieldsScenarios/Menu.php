<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings;
$module_menu = Array();

$module_menu[]= Array("index.php?module=FormFieldsScenarios&action=EditView&return_module=FormFieldsScenarios&return_action=DetailView", $mod_strings['LBL_NEW_FORM_TITLE'],"CreateFormFields");

$module_menu[]= Array("index.php?module=FormFieldsScenarios&action=index&return_module=FormFieldsScenarios&return_action=DetailView", $mod_strings['LBL_LIST_FORM_TITLE'],"FormFieldsScenarios");

?>