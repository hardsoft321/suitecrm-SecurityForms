<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class FormField extends SugarBean {

    var $id;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $created_by;
    var $created_by_name;
    var $modified_by_name;
    var $name;

    var $table_name = "form_fields";
    var $object_name = "FormField";
    var $module_dir = 'FormFields';
    var $importable = true;
    var $new_schema = true;

    public $list_id;
    public $list_name;

    function ACLAccess($view, $is_owner = 'not_set', $in_group = 'not_set')
    {
        return $GLOBALS['current_user']->isAdmin();
    }
    
    /**
	 * @see SugarBean::get_summary_text()
	 */
	public function get_summary_text()
	{
		return "$this->name";
	}
}
