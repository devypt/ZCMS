<?php

class Content_AdminController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->_model = new Model_Content();
        $this->_form = new Form_Content_Add();
        $this->_categoryModel = new Model_Category();
        $this->_categoryForm = new Form_Content_Category_Add();
        $this->_langModel = new Model_Lang();
        $this->view->langs = $this->_langModel->fetchAll();
        $this->suburi = '/content/admin/';
        $flashMessenger = $this->_helper->FlashMessenger;
        $this->view->flashmsg = implode('<br/>', $flashMessenger->getMessages('flash'));
    }

    public function indexAction() {

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
        if (!empty($filterField)) {
            $filter[$filterField] = $filterValue;
        } else {
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

    public function isactiveAction() {
        $id = $this->_request->getParam('id');
        $lang = $this->_request->getParam('lang');
        $value = $this->_request->getParam('value');
        $value = ($value == 1) ? 0 : 1;
        $result = $this->_model->updateRow($id,$lang, array('is_active' => $value));
        return $this->_redirect($this->suburi . 'index');
    }

    public function categoryisactiveAction() {
        $id = $this->_request->getParam('id');
        $lang = $this->_request->getParam('lang');
        $value = $this->_request->getParam('value');
        $value = ($value == 1) ? 0 : 1;
        $result = $this->_categoryModel->updateRow($id,$lang, array('is_active' => $value));
        return $this->_redirect($this->suburi . 'categories');
    }

    public function addAction() {
    	$lang = $this->_request->getParam('lang', '');
    	$id = $this->_request->getParam('id', '');
    	if (!empty($id) && !empty($lang)) {
    		$this->_form->removeElement('category_id');
    		$this->_form->removeElement('lang_id');
    	}
        if ($this->getRequest()->isPost()) {
            if ($this->_form->isValid($_POST)) {
            
                // if the form is valid then create the new bug
                $data = $this->_form->getvalues();
                $lang = $this->_request->getParam('lang', '');
                $id = $this->_request->getParam('id', '');
                if (!empty($id) && !empty($lang)) {
                    $row=$this->_model->find($id)->current();
                    $data['category_id']=$row->category_id;
                    $data['lang_id']=$lang;
                    $data['id']=$id;
                }else{
                	$data['id']=$this->_model->getNewContentId();
                }
                $result = $this->_model->addRow($data);
                // if the createBug method returns a result
                // then the bug was successfully created
                if ($result) {
                    $this->_redirect($this->suburi . 'index');
                }
            }
        }
       
        $this->view->form = $this->_form;
    }

    public function editAction() {
        $id = $this->_request->getParam('id','');
        $lang = $this->_request->getParam('lang','');
        $lang_uri=(!empty($lang))?'/lang/'.$lang:'';
        $this->_form->setAction('/content/admin/edit/id/' . $id.$lang_uri);
        $this->_form->setMethod('post');
        if(!empty($id)&&!empty($lang))
        {
            $this->_form->removeElement('lang_id');
            $this->_form->removeElement('category_id');
        }
        if ($this->getRequest()->isPost()) {
            if ($this->_form->isValid($_POST)) {
                $data=$this->_form->getValues();
                $data['id']=$id;
                $data['lang_id']=$lang;
                $category_id=$this->_model->getCategoryId($id);
                $data['category_id']=$category_id;
                $result = $this->_model->updateRow($id,$lang, $data);
                return $this->_redirect($this->suburi . 'index');
            }
        } else {
            
            $row = $this->_model->getRowWhere($id,$lang);
            $this->_form->populate($row->toArray());
        }
        $this->view->form = $this->_form;
    }

    public function deleteAction() {
        $id = $this->_request->getParam('id');
        $lang = $this->_request->getParam('lang');
        $this->_model->deleteRow($id,$lang);
        return $this->_redirect($this->suburi . 'index');
    }

//category methods
    public function categoriesAction() {

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
        if (!empty($filterField)) {
            $filter[$filterField] = $filterValue;
        } else {
            $filter = null;
        }
        // now you need to manually set these controls values
        $ToolsForm->getElement('sort')->setValue($sort);
        $ToolsForm->getElement('filter_field')->setValue($filterField);
        $ToolsForm->getElement('filter')->setValue($filterValue);
        // fetch the bug paginator adapter
        $adapter = $this->_categoryModel->fetchPaginatorAdapter($filter, $sort);
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

    public function addcategoryAction() {
        $lang = $this->_request->getParam('lang', '');
    	$id = $this->_request->getParam('id', '');
    	if (!empty($id) && !empty($lang)) {
    		$this->_categoryForm->removeElement('parent_id');
    		$this->_categoryForm->removeElement('lang_id');
    	}
        if ($this->getRequest()->isPost()) {
            if ($this->_categoryForm->isValid($_POST)) {
                
                // if the form is valid then create the new bug
                $data = $this->_categoryForm->getvalues();
                if (!empty($id) && !empty($lang)) {
    		$data['parent_id']=$this->_categoryModel->getParentId($id);
                $data['lang_id']=$lang;
                $data['id']=$id;
    	}else{
            $data['id']=$this->_categoryModel->getNewRowId();
        }
                $result = $this->_categoryModel->addRow($data);
                // if the createBug method returns a result
                // then the bug was successfully created
                if ($result) {
                    $flashMessenger = $this->_helper->FlashMessenger;
                    $flashMessenger->setNamespace('flash');
                    $flashMessenger->addMessage('$message');


                    $this->_redirect($this->suburi . 'categories');
                }
            }
        }
        $this->view->form = $this->_categoryForm;
    }

    public function editcategoryAction() {
        $id = $this->_request->getParam('id');
        $lang = $this->_request->getParam('lang','');
        $lang_uri=(!empty($lang))?'/lang/'.$lang:'';
        $this->_categoryForm->setAction('/content/admin/editcategory/id/' . $id.$lang_uri);
        if (!empty($id) && !empty($lang)) {
    		$this->_categoryForm->removeElement('parent_id');
    		$this->_categoryForm->removeElement('lang_id');
        }
        $this->_categoryForm->setMethod('post');
        if ($this->getRequest()->isPost()) {
            if ($this->_categoryForm->isValid($_POST)) {
// if the form is valid then update the bug
                $result = $this->_categoryModel->updateRow($id, $lang,$this->_categoryForm->getValues());
                return $this->_redirect($this->suburi . 'categories');
            }
        } else {
            $row = $this->_categoryModel->find($id)->current();
            $this->_categoryForm->populate($row->toArray());
        }
        $this->view->form = $this->_categoryForm;
    }

    public function deletecategoryAction() {
        $id = $this->_request->getParam('id');
        $lang = $this->_request->getParam('lang');
        $this->_categoryModel->deleteRow($id,$lang);
        return $this->_redirect($this->suburi . 'categories');
    }
    public function buildAction()
{
// create the index
$index = Zend_Search_Lucene::create(APPLICATION_PATH . '/indexes');
// fetch all of the current pages
$currentPages = $this->_model->fetchAll();
if($currentPages->count() > 0) {

// create a new search document for each page
foreach ($currentPages as $page) {
$doc = new Zend_Search_Lucene_Document();
// you use an unindexed field for the id because you want the id
// to be included in the search results but not searchable
$doc->addField(Zend_Search_Lucene_Field::unIndexed('page_id',
$page->id));
// you use text fields here because you want the content to be searchable
// and to be returned in search results
$doc->addField(Zend_Search_Lucene_Field::text('page_name',
$page->name));
$doc->addField(Zend_Search_Lucene_Field::text('page_slug',
$page->slug));
$doc->addField(Zend_Search_Lucene_Field::text('page_content',
$page->content));
// add the document to the index
$index->addDocument($doc);
}
}
// optimize the index
$index->optimize();
// pass the view data for reporting
$this->view->indexSize = $index->numDocs();
}

}

