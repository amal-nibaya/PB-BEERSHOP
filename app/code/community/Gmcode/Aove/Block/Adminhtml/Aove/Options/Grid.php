    <?php

    class Gmcode_Aove_Block_Adminhtml_Aove_Options_Grid extends Mage_Adminhtml_Block_Widget_Grid
    {
        public function __construct()
        {
            parent::__construct();
            $this->setId('optionsGrid');
            // This is the primary key of the database
            $this->setDefaultSort('option_id');
            $this->setDefaultDir('DESC');
            $this->setSaveParametersInSession(true);
            $this->setUseAjax(true);
        }

        public function getMainButtonsHtml()
        {
            $html = parent::getMainButtonsHtml();//get the parent class buttons
            $addButton = $this->getLayout()->createBlock('adminhtml/widget_button') //create the add button
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Add Option'),
                    'onclick'   => "setLocation('".$this->getUrl('*/*/optionsnew')."')",
                    'class'   => 'task'
                ))->toHtml();
            return $addButton.$html;
        }

        protected function _prepareCollection()
        {
            $collection = Mage::getModel('aove/options')->getCollection();
            $attribute_id = Mage::registry('aove_data')->getId();
            $collection->addFieldToFilter('attribute_id', $attribute_id);

      			foreach($collection as $link){
      				if($link->getStores() && $link->getStores() != 0 ){
      					$link->setStores(explode(',',$link->getStores()));
      				}
      				else{
      					$link->setStores(array('0'));
      				}
      			}
            $this->setCollection($collection);
            return parent::_prepareCollection();
        }

        protected function _prepareColumns()
        {
            $this->addColumn('option_id', array(
                'header'    => Mage::helper('aove')->__('ID'),
                'align'     =>'right',
                'width'     => '50px',
                'index'     => 'option_id',
            ));

            $this->addColumn('perent_id', array(
                'header'    => Mage::helper('aove')->__('Perent Id'),
                'align'     =>'right',
                'width'     => '50px',
                'index'     => 'perent_id',
            ));

            $this->addColumn('title', array(
                'header'    => Mage::helper('aove')->__('Title'),
                'align'     =>'left',
                'index'     => 'title',
            ));

            $this->addColumn('status', array(
                'header'    => Mage::helper('aove')->__('Status'),
                'align'     => 'left',
                'width'     => '80px',
                'index'     => 'status',
                'type'      => 'options',
                'options'   => array(
                    1 => 'Active',
                    0 => 'Inactive',
                ),
            ));

            return parent::_prepareColumns();
        }

        public function getRowUrl($row)
        {
            return $this->getUrl('*/*/optionsedit', array('id' => $row->getId()));
        }

        public function getGridUrl()
        {
          return $this->getUrl('*/*/optionsgrid', array('_current'=>true));
        }

		protected function _filterStoreCondition($collection, $column)
		{

			if (!$value = $column->getFilter()->getValue()) {
				return;
			}
			$this->getCollection()->addStoreFilter($value);
		}

    }
