<?php

class AdminController extends Zend_Controller_Action {

    public function init() {

        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //TODO 
        
    }
    public function editLangAction() {
        $lang_id = $this->_request->getParam('id', '1');
        $this->_form = new Form_Default_Setting();
        $this->_model = new Model_Setting();
        if ($this->getRequest()->isPost()) {
            if ($this->_form->isValid($_POST)) {
                $data = $this->_form->getvalues();
                 $this->_model->updateRow($lang_id, $data);
        
                    return $this->_redirect($this->view->url(array('module'=>'default','controller'=>'admin','action'=>'langs')));
                
            }
        }
        $row = $this->_model->find($lang_id)->current();
        $this->_form->populate($row->toArray());
        $this->view->form = $this->_form;
    }

    public function langsAction() {
        $model = new Model_Lang();
        $adapter = $model->fetchPaginatorAdapter();
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
    public function isactiveLangAction() {
        $id = $this->_request->getParam('id');
        $value = $this->_request->getParam('value');
        $value = ($value == 1) ? 0 : 1;
        $model = new Model_Lang();
        $result = $model->updateRow($id, array('is_active' => $value));
        return $this->_redirect($this->view->url(array('module'=>'default','controller'=>'admin','action'=>'langs')));
    }
}

