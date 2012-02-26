<?php

class IndexController extends My_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $filter['is_active'] = 1;
        $filter['lang_id'] = 1;
        $sort['DESC'] = '';
        // now you need to manually set these controls values
        $contentModel = new Model_Content();
        $adapter = $contentModel->fetchPaginatorAdapter($filter, $sort);
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

}

