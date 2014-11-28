<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings;
$module_menu = Array();

$module_menu[]= Array("index.php?module=FormFieldsLists&action=EditView&return_module=FormFieldsLists&return_action=DetailView", $mod_strings['LBL_NEW_FORM_TITLE'],"CreateFormFields");

$module_menu[]= Array("index.php?module=FormFieldsLists&action=index&return_module=FormFieldsLists&return_action=DetailView", $mod_strings['LBL_LIST_FORM_TITLE'],"FormFieldsLists");

?>