<?php

class User_AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       $model = new Model_User();
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
		$model = new Model_User();
		$adapter = $model->fetchPaginatorAdapter($filter, $sort);
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
		$form=new Form_User_Add();
           
		if($this->getRequest()->isPost()) {
			if($form->isValid($_POST)) {
				$model = new Model_User();
				// if the form is valid then create the new bug
				$data=$form->getvalues();
				$data['password']=sha1($data['password']);
				$result = $model->addRow($data);
				// if the createBug method returns a result
				// then the bug was successfully created
				if($result) {
					$this->_forward('index');
				}
			}
		}
		$this->view->form = $form;
		
	}
public function editAction()
{
$id = $this->_request->getParam('id');
$model = new Model_User();
$form = new Form_User_Add();
$form->setAction('/user/admin/edit/id/'.$id);
$form->setMethod('post');
if($this->getRequest()->isPost()) {
if($form->isValid($_POST)) {
// if the form is valid then update the bug
$result = $model->updateRow($id,$form->getValues());
return $this->_forward('index');
}
} else {
$row = $model->find($id)->current();
$form->populate($row->toArray());
}
$this->view->form = $form;
	
}
	
public function deleteAction()
{
$model = new Model_User();
$id = $this->_request->getParam('id');
$model->deleteRow($id);
return $this->_forward('index');
}



}

