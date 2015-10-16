<?php

class Gmcode_Aove_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
			->_setActiveMenu('aove/manage_aove')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction();
		$this->_addContent($this->getLayout()->createBlock('aove/adminhtml_aove'));
		$this->renderLayout();
	}

	public function editAction()
	{
		$aoveId     = $this->getRequest()->getParam('id');
		$aoveModel  = Mage::getModel('aove/attributes')->load($aoveId);

		if ($aoveModel->getId() || $aoveId == 0) {

			Mage::register('aove_data', $aoveModel);

			$this->loadLayout();
			$this->_setActiveMenu('aove/manage_aove');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('aove/adminhtml_aove_edit'))
				 ->_addLeft($this->getLayout()->createBlock('aove/adminhtml_aove_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('aove')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function optionseditAction()
	{
		$aoveId     = $this->getRequest()->getParam('id');
		$aoveModel  = Mage::getModel('aove/options')->load($aoveId);

		if ($aoveModel->getId() || $aoveId == 0) {

			Mage::register('aove_options_data', $aoveModel);
			$this->loadLayout();
			$this->_setActiveMenu('aove/manage_aove');
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('aove/adminhtml_aove_options_edit'))
			// $this->_addContent($this->getLayout()->createBlock('aove/adminhtml_aove_options_edit_tab_form'))
				->_addLeft($this->getLayout()->createBlock('aove/adminhtml_aove_options_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('aove')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function optionsnewAction()
	{
		$this->_forward('optionsedit');
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function optionssaveAction()
	{
		if ( $this->getRequest()->getPost() ) {
			try {
				$postData = $this->getRequest()->getPost();

				if(isset($postData['attribute'])) { // save attribute
					$aoveModel = Mage::getModel('aove/attributes');
					$aoveModel->setId($this->getRequest()->getParam('id'))
						->setAttribute($postData['attribute'])
						->save();

					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Attribute was successfully saved'));
					Mage::getSingleton('adminhtml/session')->setaoveData(false);

					$this->_redirect('*/*/');
					return;
				}
				else { // save option
					$aoveModel = Mage::getModel('aove/options');
					$slidesPath = Mage::helper('aove')->getAovePath();

					if(isset($_FILES['image_name']['name']) && $_FILES['image_name']['name'] != '') {
						try {

							/* Starting upload */
							$uploader = new Varien_File_Uploader('image_name');

							// Any extention would work
							$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
							$uploader->setAllowRenameFiles(true);

							// Set the file upload mode
							// false -> get the file directly in the specified folder
							// true -> get the file in the product like folders
							//	(file.jpg will go in something like /media/f/i/file.jpg)
							$uploader->setFilesDispersion(false);

							// We set media as the upload dir
							$path = Mage::getBaseDir('media') . DS . $slidesPath ;
							$result = $uploader->save($path, $_FILES['image_name']['name'] );
							$postData['image_name'] = $slidesPath.$result['file'];
						} catch (Exception $e) {
							$postData['image_name'] = $_FILES['image_name']['name'];
						}
					}
					else {
						unset($postData['image_name']);
					}

					$optionModel = $aoveModel->setId($this->getRequest()->getParam('id'));
					$attribute_id = $aoveModel->load($this->getRequest()->getParam('id'))->getData('attribute_id');

					if(empty($attribute_id)) {
						$session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
						$attribute_id = $session->getData("attribute_id");
						$optionModel->setAttributeId($attribute_id);
					}

					$optionModel->setPerentId($postData['perent_id'])
						->setTitle($postData['title'])
						->setContent($postData['content'])
						->setStatus($postData['status']);

					if(isset($postData['image_name'])) {
						$optionModel->setImageName($postData['image_name']);
					}
					$optionModel->save();

					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Option was successfully saved'));
					Mage::getSingleton('adminhtml/session')->setaoveData(false);

					if ($this->getRequest()->getParam('back')) {
						$this->_redirect('*/*/optionsedit', array("id"=>$this->getRequest()->getParam('id')));
					}
					else {
						$this->_redirect('*/*/edit', array("id"=>$attribute_id, 'active_tab' => 'option_section'));
					}
					return;

				}
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setaoveData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		$this->_redirect('*/*/');
	}

	public function saveAction()
	{
		if ( $this->getRequest()->getPost() ) {
			try {
				$postData = $this->getRequest()->getPost();
				$aoveModel = Mage::getModel('aove/attributes');

				$slidesPath = Mage::helper('aove')->getAovePath();

				if(isset($_FILES['image_name']['name']) && $_FILES['image_name']['name'] != '') {
					try {

						/* Starting upload */
						$uploader = new Varien_File_Uploader('image_name');

						// Any extention would work
		        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
						$uploader->setAllowRenameFiles(true);

						// Set the file upload mode
						// false -> get the file directly in the specified folder
						// true -> get the file in the product like folders
						//	(file.jpg will go in something like /media/f/i/file.jpg)
						$uploader->setFilesDispersion(false);

						// We set media as the upload dir
						$path = Mage::getBaseDir('media') . DS . $slidesPath ;
						$result = $uploader->save($path, $_FILES['image_name']['name'] );

						//For thumb
						Mage::helper('aove')->resizeImg($result['file'], 100, 75);
						//For thumb ends

						$test = $slidesPath.$result['file'];

						//$postData['image_name'] = $slidesPath.$result['file'];

						if(isset($postData['image_name']['delete']) && $postData['image_name']['delete'] == 1)
						{
							//Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['image_name']['value'];
							unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['image_name']['value']);
							unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS . Mage::helper('aove')->getThumbsPath($postData['image_name']['value']));
						}
						$postData['image_name'] = $test;

					} catch (Exception $e) {
						$postData['image_name'] = $_FILES['image_name']['name'];
			        }
				}
				else {

					if(isset($postData['image_name']['delete']) && $postData['image_name']['delete'] == 1){
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['image_name']['value']);
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .Mage::helper('aove')->getThumbsPath($postData['image_name']['value']));
						$postData['image_name'] = '';
						}
					else
						unset($postData['image_name']);
				}

				if(isset($postData['stores'])) {
					if(in_array('0',$postData['stores'])){
						$postData['stores'] = '0';
					}
					else{
						$postData['stores'] = implode(",", $postData['stores']);
					}
				    //unset($postData['stores']);
				}

				if($postData['stores'] == "")
				{
					$postData['stores'] = '0';
				}

				// echo "<pre>";
				// var_dump($postData);
				// // var_dump($aoveModel);
				//
				// echo "</pre>";
				//
				// echo "## ".$this->getRequest()->getParam('id');
				// exit;

				$aoveModel->setId($this->getRequest()->getParam('id'))
					->setTitle($postData['title'])
					->setAttribute($postData['attribute'])
					->setStatus($postData['status'])
					->save();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setaoveData(false);

				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setaoveData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		$this->_redirect('*/*/');
	}

	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$aoveModel = Mage::getModel('aove/aove');

				$aoveModel->setId($this->getRequest()->getParam('id'))
					->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
	/**
	 * Product grid for AJAX request.
	 * Sort and filter result for example.
	 */
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('aove/adminhtml_aove_grid')->toHtml()
		);
	}
}
?>
