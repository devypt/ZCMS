<?php

class Menu_AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_model=new Model_Menu();
    	$this->_form=new Form_Menu_Add();
        $this->_itemModel=new Model_Menuitem();
        $this->_itemForm=new Form_Menu_Item_Add();
    }

    public function indexAction()
    {
    	
		$ToolsForm = new Form_User_ToolsForm();
		$sort = null;
		$filter = null;
		$ToolsForm->setAction('');
		$ToolsForm->setMethod('post');
		$this->view->ToolsForm = $ToolsForm;
		// set the sort and filter criteria. you need to update this to use the request,
		// as these values can come in from the form post or a url parameter
		$sort = $this->_request->getParam('sort', null);
		$filterField = $this->_request->getParam('filter_field', null);
		$filterValue = $this->_request->getParam('filter');
		if(!empty($filterField)) {
			$filter[$filterField] = $filterValue;
		}else{
			$filter = null;
		}
		// now you need to manually set these controls values
		$ToolsForm->getElement('sort')->setValue($sort);
		$ToolsForm->getElement('filter_field')->setValue($filterField);
		$ToolsForm->getElement('filter')->setValue($filterValue);
		// fetch the bug paginator adapter
		$adapter = $this->_model->fetchPaginatorAdapter($filter, $sort);
		$paginator = new Zend_Paginator($adapter);
		// show 10 bugs per page
		$paginator->setItemCountPerPage(10);
		// get the page number that is passed in the request.
		//if none is set then default to page 1.
		$page = $this->_request->getParam('page', 1);
		$paginator->setCurrentPageNumber($page);
		// pass the paginator to the view to render
		$this->view->paginator = $paginator;		
		
		
    }
	
	public function addAction()
	{
		if($this->getRequest()->isPost()) {
			if($this->_form->isValid($_POST)) {
				// if the form is valid then create the new bug
				$data=$this->_form->getvalues();
				$result = $this->_model->addRow($data);
				// if the createBug method returns a result
				// then the bug was successfully created
				if($result) {
					$this->_forward('index');
				}
			}
		}
		$this->view->form = $this->_form;
		
	}
public function editAction()
{
$id = $this->_request->getParam('id');
$this->_form->setAction('/menu/admin/edit/id/'.$id);
$this->_form->setMethod('post');
if($this->getRequest()->isPost()) {
if($this->_form->isValid($_POST)) {
// if the form is valid then update the bug
$result = $this->_model->updateRow($id,$this->_form->getValues());
return $this->_forward('index');
}
} else {
$row = $this->_model->find($id)->current();
$this->_form->populate($row->toArray());
}
$this->view->form = $this->_form;
	
}
	
public function deleteAction()
{
$id = $this->_request->getParam('id');
$this->_model->deleteRow($id);
return $this->_forward('index');
}

//category methods
public function itemsAction()
    {
    	
		$ToolsForm = new Form_User_ToolsForm();
		$sort = null;
		$filter = null;
		$ToolsForm->setAction('');
		$ToolsForm->setMethod('post');
		$this->view->ToolsForm = $ToolsForm;
		// set the sort and filter criteria. you need to update this to use the request,
		// as these values can come in from the form post or a url parameter
		$sort = $this->_request->getParam('sort', null);
		$filterField = $this->_request->getParam('filter_field', null);
		$filterValue = $this->_request->getParam('filter');
		if(!empty($filterField)) {
			$filter[$filterField] = $filterValue;
		}else{
			$filter = null;
		}
		// now you need to manually set these controls values
		$ToolsForm->getElement('sort')->setValue($sort);
		$ToolsForm->getElement('filter_field')->setValue($filterField);
		$ToolsForm->getElement('filter')->setValue($filterValue);
		// fetch the bug paginator adapter
		$adapter = $this->_itemModel->fetchPaginatorAdapter($filter, $sort);
		$paginator = new Zend_Paginator($adapter);
		// show 10 bugs per page
		$paginator->setItemCountPerPage(10);
		// get the page number that is passed in the request.
		//if none is set then default to page 1.
		$page = $this->_request->getParam('page', 1);
		$paginator->setCurrentPageNumber($page);
		// pass the paginator to the view to render
		$this->view->paginator = $paginator;		
		
		
    }
	
	public function additemAction()
	{
		if($this->getRequest()->isPost()) {
			if($this->_itemForm->isValid($_POST)) {
				// if the form is valid then create the new bug
				$data=$this->_itemForm->getvalues();
				$result = $this->_itemModel->addRow($data);
				// if the createBug method returns a result
				// then the bug was successfully created
				if($result) {
					$this->_forward('items');
				}
			}
		}
     	$this->view->form = $this->_itemForm;
		
	}
public function edititemAction()
{
$id = $this->_request->getParam('id');
$this->_itemForm->setAction('/content/admin/editcategory/id/'.$id);
$this->_itemForm->setMethod('post');
if($this->getRequest()->isPost()) {
if($this->_itemForm->isValid($_POST)) {
// if the form is valid then update the bug
$result = $this->_itemModel->updateRow($id,$this->_itemForm->getValues());
return $this->_forward('items');
}
} else {
$row = $this->_itemModel->find($id)->current();
$this->_itemForm->populate($row->toArray());
}
$this->view->form = $this->_itemForm;
	
}
	
public function deleteitemAction()
{
$id = $this->_request->getParam('id');
$this->_itemModel->deleteRow($id);
return $this->_forward('items');
}












}

