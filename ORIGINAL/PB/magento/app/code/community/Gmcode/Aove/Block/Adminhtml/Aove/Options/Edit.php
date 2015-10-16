    <?php

    class Gmcode_Aove_Block_Adminhtml_Aove_Options_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
    {
        public function __construct()
        {
            parent::__construct();

            $this->_objectId = 'ids';
            $this->_blockGroup = 'aove';
            $this->_controller = 'adminhtml_aove';

            $this->_updateButton('save', 'label', Mage::helper('aove')->__('Save Item'));
            $this->_updateButton('delete', 'label', Mage::helper('aove')->__('Delete Item'));
            $this->_addButton('saveandcontinue', array(
                'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
                'onclick'   => 'saveAndContinueEdit()',
                'class'     => 'save',
            ), -100);
            $this->_formScripts[] = "
             function saveAndContinueEdit(){
                editForm.submit($('edit_form').action + 'back/edit/');
             }
             ";

        }

        public function getHeaderText()
        {
            if( Mage::registry('aove_options_data') && Mage::registry('aove_options_data')->getId() ) {
                return Mage::helper('aove')->__("Edit Option '%s'",
                  $this->htmlEscape(Mage::registry('aove_options_data')->getTitle()));
            } else {
                return Mage::helper('aove')->__('Add Item');
            }
        }
    }
