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

    public $sf_module;
    public $scenario;

    function bean_implements($interface){
        switch($interface){
            case 'ACL':return true;
        }
        return false;
    }
    
    /**
	 * @see SugarBean::get_summary_text()
	 */
	public function get_summary_text()
	{
		return "$this->name";
	}
}
