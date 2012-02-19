<?php

class Content_IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->_model = new Model_Content();
        $this->_form = new Form_Content_Add();
        $this->_categoryModel = new Model_Category();
        $this->_categoryForm = new Form_Content_Category_Add();
    }

    public function indexAction() {

        $sort = $this->_request->getParam('sort', null);
        $filterField = $this->_request->getParam('filter_field', null);
        $filterValue = $this->_request->getParam('filter');
        if (!empty($filterField)) {
            $filter[$filterField] = $filterValue;
        } else {
            $filter = null;
        }
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

    public function categoryAction() {

        $sort = $this->_request->getParam('sort', null);
        $filterField = $this->_request->getParam('filter_field', null);
        $filterValue = $this->_request->getParam('filter');
        if (!empty($filterField)) {
            $filter[$filterField] = $filterValue;
        } else {
            $filter = null;
        }
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

    public function viewAction() {
        $slug = $this->_request->getParam('slug', '');

        // first confirm the page exists
        $bootstrap = $this->getInvokeArg('bootstrap');
        $cache = $bootstrap->getResource('cache');
        $cacheKey = 'content_page_' . $slug;
        $page = $cache->load($cacheKey);
        if (!$page) {
             $row = $this->_model->getRow($slug);
// add a cache tag to this menu so you can update the cached menu
// when you update the page
            $tags[] = 'page_' . $row->slug;
            $cache->save($row, $cacheKey, $tags);
        }else{
            $row = $page;
        }
        $this->view->row = $row;
        $this->view->pageTitle=$row->name;
    }

    public function searchAction() {
        if ($this->_request->isPost()) {
            $keywords = $this->_request->getParam('query');
            $query = Zend_Search_Lucene_Search_QueryParser::parse($keywords);
            $index = Zend_Search_Lucene::open(APPLICATION_PATH . '/indexes');
            $hits = $index->find($query);
            $this->view->results = $hits;
            $this->view->keywords = $keywords;
        } else {
            $this->view->results = null;
        }
    }

    public function categoriesAction() {

        $sort = $this->_request->getParam('sort', null);
        $filterField = $this->_request->getParam('filter_field', null);
        $filterValue = $this->_request->getParam('filter');
        if (!empty($filterField)) {
            $filter[$filterField] = $filterValue;
        } else {
            $filter = null;
        }

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

    public function feedAction() {
        // build the feed array
        $feedArray = array();
// the title and link are required
        $feedArray['title'] = 'Recent Pages';
        $feedArray['link'] = 'http://localhost';
// the published timestamp is optional
        $feedArray['published'] = Zend_Date::now()->toString(Zend_Date::TIMESTAMP);
// the charset is required
        $feedArray['charset'] = 'UTF8';
// first get the most recent pages
        $recentPages = $this->_model->fetchAll();
//add the entries
        foreach ($recentPages as $page) {
// create the entry
            $entry = array();
            $entry['guid'] = $page->id;
            $entry['title'] = $page->name;
            $entry['link'] = 'http://zfcms.me' . $this->view->url(array('module' => 'content', 'controller' => 'index', 'action' => 'view', 'slug' => $page->slug));
            $entry['description'] = $page->name;
            $entry['content'] = $page->content;
            $feedArray['entries'][] = $entry;
        }
        $feed = Zend_Feed::importArray($feedArray, 'rss');
// now send the feed
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $feed->send();
    }

}
