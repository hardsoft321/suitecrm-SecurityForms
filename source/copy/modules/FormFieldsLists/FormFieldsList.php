<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class FormFieldsList extends SugarBean {

    var $id;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $created_by;
    var $created_by_name;
    var $modified_by_name;
    var $name;

    var $table_name = "form_fields_lists";
    var $object_name = "FormFieldsList";
    var $module_dir = 'FormFieldsLists';
    var $importable = true;
    var $new_schema = true;

    public $list_type;
    public $parent_id;
    public $parent_type;
    public $parent_name;

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
