<?php

class Gmcode_Aove_Model_Attributes extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('aove/attributes');
    }
}
