<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class FormFieldsScenario extends SugarBean {

    var $id;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $created_by;
    var $created_by_name;
    var $modified_by_name;
    var $name;

    var $table_name = "form_fields_scenarios";
    var $object_name = "FormFieldsScenario";
    var $module_dir = 'FormFieldsScenarios';
    var $importable = true;
    var $new_schema = true;

    public $uniq_name;
    public $sf_module;

    function bean_implements($interface){
        switch($interface){
            case 'ACL':return true;
        }
        return false;
    }

    public static function hasScenario($scenarioUName, $scenarioModule) {
        global $db;
        $query = "SELECT 1 FROM form_fields_scenarios s
        WHERE
            s.uniq_name = '$scenarioUName'
            AND s.sf_module = '$scenarioModule'
            AND s.deleted = 0";
        return (bool) $db->fetchOne($query);
    }

    public static function getScenarioFieldsNames($scenarioUName, $scenarioModule) {
        global $db;
        $query = "SELECT f.name
        FROM form_fields f, form_fields_scenarios s
        WHERE f.scenario_id = s.id
            AND s.uniq_name = '$scenarioUName'
            AND s.sf_module = '$scenarioModule'
            AND f.deleted = 0
            AND s.deleted = 0";
        $dbRes = $db->query($query);
        $fields = array();
        while($row = $db->fetchByAssoc($dbRes)) {
            $fields[] = $row['name'];
        }
        return $fields;
    }

    /**
	 * @see SugarBean::get_summary_text()
	 */
	public function get_summary_text()
	{
		return "$this->name";
	}
}
