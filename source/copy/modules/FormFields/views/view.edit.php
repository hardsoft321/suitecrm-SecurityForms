<?php
class FormFieldsViewEdit extends ViewEdit
{
    public $useForSubpanel = true;

    public function display()
    {
        if(!empty($_REQUEST['parent_id']) && !empty($_REQUEST['parent_type'])) {
            $list = BeanFactory::getBean($_REQUEST['parent_type'], $_REQUEST['parent_id']);
        }
        else if(!empty($_REQUEST['relate_id']) && !empty($_REQUEST['relate_to']) && $_REQUEST['relate_to'] == 'list_fields') {
            $list = BeanFactory::getBean('FormFieldsLists', $_REQUEST['relate_id']);
        }
        if(!empty($list)) {
            $_REQUEST['list_id'] = $list->id;
            $_REQUEST['list_name'] = $list->name;
        }
        parent::display();
    }
}
