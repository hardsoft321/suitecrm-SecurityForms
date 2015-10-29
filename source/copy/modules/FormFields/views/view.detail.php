<?php
require_once('include/MVC/View/views/view.detail.php');

class FormFieldsViewDetail extends ViewDetail
{
    function display()
    {
        global $app_list_strings;
        $str = '';
        foreach($app_list_strings['moduleList'] as $module => $moduleName) {
            $b = BeanFactory::newBean($module);
            if(isset($b->field_defs[$this->bean->name])) {
                $label = isset($b->field_defs[$this->bean->name]['vname']) ? translate($b->field_defs[$this->bean->name]['vname'], $module) : $this->bean->name;
                $str .= ($str ? ', ': '').$moduleName.': '.$label;
            }
        }
        if($str) {
            $this->bean->description = $str;
        }
        parent::display();
    }   
}
