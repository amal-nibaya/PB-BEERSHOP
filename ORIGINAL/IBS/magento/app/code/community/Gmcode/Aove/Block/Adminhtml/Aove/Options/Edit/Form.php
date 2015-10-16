    <?php

    class Gmcode_Aove_Block_Adminhtml_Aove_Options_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
    {
        protected function _prepareForm()
        {
            $form = new Varien_Data_Form(array(
            			'id' => '',
            			'action' => $this->getUrl('*/*/optionssave', array('id' => $this->getRequest()->getParam('id'))),
            			'method' => 'post',
            			'enctype' => 'multipart/form-data'
            		 )
            );
            $form->setUseContainer(false);
            $this->setForm($form);
            return parent::_prepareForm();
        }
    }
