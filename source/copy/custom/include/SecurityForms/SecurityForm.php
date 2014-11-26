<?php
class SecurityForm {

    /**
     * Версия js-файлов.
     * Изменить после обновления js.
     */
    const JS_CUSTOM_VERSION = '0.0.1';

    /**
     * По умолчанию скрывать всю форму
     */
    const MODE_DEFAULT_DISABLED = 1;
    
    /**
     * По умолчанию показывать всю форму
     */
    const MODE_DEFAULT_ENABLED = 2;

    private $mode = self::MODE_DEFAULT_ENABLED;
    private $enabledFields = array();
    private $disabledFields = array();

    public function __construct() {
    }

    protected function getEnabledFields() {
        return $this->enabledFields;
    }

    protected function setEnabledFields($fields) {
        $this->enabledFields = $fields;
    }

    protected function getDisabledFields() {
        return $this->enabledFields;
    }

    protected function setDisabledFields($fields) {
        $this->enabledFields = $fields;
    }

    public function setDefaultEnabledMode() {
        $this->mode = self::MODE_DEFAULT_ENABLED;
    }

    public function setDefaultDisabledMode() {
        $this->mode = self::MODE_DEFAULT_DISABLED;
    }

    public function getMode() {
        return $this->mode;
    }

    /**
     * Хук на событие after_ui_frame для формы редактирования.
     * Выводит скрипт блокирования полей.
     */
    public function afterUiFrame($event, $arguments) {
        if($this->isEditView()) {
            echo $this->getAfterEditView();
        }
    }

    public function getAfterEditView() {
        if($this->mode == self::MODE_DEFAULT_ENABLED) {
            //TODO: realize getDisableFieldsJs
            return '';
        }
        $enabledFields = array();
        if($this->mode == self::MODE_DEFAULT_DISABLED) {
            $enabledFields = $this->getEnabledFields();
        }
        return $this->getStyle()
            .$this->getVersionedScript()
            .$this->getDisableFormJs($enabledFields);
    }

    /**
     * Хук на событие before_save сохранения бина.
     * Отменяет изменения в полях.
     */
    public function beforeSave($bean, $event) {
        /*$enabledFields = $this->getEnabledFields();
        $diff = $bean->db->getDataChanges($bean);
        foreach($diff as $changes) {
            $field = $changes['field_name'];
            if(in_array($field, array('date_modified', 'modified_user_id', 'modified_by_name'))) {
                continue;
            }
            if(in_array($field, $enabledFields)) {
                continue;
            }
            $bean->$field = $changes['before'];
            $GLOBALS['log']->info("SecurityForms: {$bean->module_name} field $field change canseled");
        }*/
        //TODO: undo relationship delete/add
        //TODO: while relationship not canseled, audit canceled, that's bad
    }

    protected function getVersionedScript() {
        return getVersionedScript('custom/include/SecurityForms/js/securityforms.js', self::JS_CUSTOM_VERSION);
    }

    protected function getStyle() {
        return "
<style>
input.sf-disabled, textarea.sf-disabled, ul.sf-select {
    color: #717171;
    background-color: #f6f6f6;
}
ul.sf-select {
    border: 1px solid;
    border-color: #94C1E8;
    display: inline-block;
    min-height: 15px;
    margin: 0;
    padding-left: 0;
    padding-right:6px;
}
ul.sf-select li {
    margin: 1px 3px;
}
</style>";
    }

    protected function getDisableFormJs($enabledFields) {
        return "
<script type=\"text/javascript\">
    lab321.sform.disableForm('EditView', ".json_encode($enabledFields).");
</script>
"; //TODO: disable emailAddressesTable, radio buttons?
//TODO: disable after ajaxui frame
    }

    protected function isEditView() {
        $action = $_REQUEST['action'];
        $module = $_REQUEST['module'];
        $action = strtolower($action);
        if($module && ($action == "editview") && (!isset($_REQUEST['search_form_only']) || !$_REQUEST['search_form_only'])) {
            return true;
        }
        return false;
    }
}
