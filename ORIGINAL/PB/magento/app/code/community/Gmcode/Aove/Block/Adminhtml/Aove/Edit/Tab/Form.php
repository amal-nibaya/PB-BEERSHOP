    <?php

    class Gmcode_Aove_Block_Adminhtml_Aove_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
    {
        protected function _prepareForm()
        {
            $form = new Varien_Data_Form();
            $this->setForm($form);
            $fieldset = $form->addFieldset('aove_form', array('legend'=>Mage::helper('aove')->__('Attribute information')));

            $fieldset->addField('attribute', 'text', array(
                'label'     => Mage::helper('aove')->__('Attribute'),
                'class'     => 'required-entry',
                'required'  => true,
                'name'      => 'attribute',
            ));

            if ( Mage::getSingleton('adminhtml/session')->getAoveData() )
            {
                $form->setValues(Mage::getSingleton('adminhtml/session')->getAoveData());
                Mage::getSingleton('adminhtml/session')->setAoveData(null);
            } elseif ( Mage::registry('aove_data') ) {
                $form->setValues(Mage::registry('aove_data')->getData());
            }
            return parent::_prepareForm();
        }
    }
