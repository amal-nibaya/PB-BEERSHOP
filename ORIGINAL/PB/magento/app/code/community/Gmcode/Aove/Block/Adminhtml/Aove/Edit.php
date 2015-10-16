    <?php

    class Gmcode_Aove_Block_Adminhtml_Aove_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
    {
        public function __construct()
        {
            parent::__construct();

            $this->_objectId = 'id';
            $this->_blockGroup = 'aove';
            $this->_controller = 'adminhtml_aove';

            $this->_updateButton('save', 'label', Mage::helper('aove')->__('Save Item'));
            $this->_updateButton('delete', 'label', Mage::helper('aove')->__('Delete Item'));
        }

        public function getHeaderText()
        {
            if( Mage::registry('aove_data') && Mage::registry('aove_data')->getId() ) {
                return Mage::helper('aove')->__("Edit Attribute '%s'", $this->htmlEscape(Mage::registry('aove_data')->getTitle()));
            } else {
                return Mage::helper('aove')->__('Add Item');
            }
        }
    }
