<?php

class Gmcode_Aove_Model_Mysql4_Options extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('aove/options', 'option_id');
    }
}
