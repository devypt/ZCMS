<?php

class Model_Category extends Zend_Db_Table_Abstract {

    protected $_name = 'categories';
    protected $_primary = 'id';

    public function addRow($data) {


        $row = $this->createRow();
        foreach ($data as $k => $v) {
            $row->$k = $v;
        }

        $row->save();
        return true;
    }

    public function isCategoryExistForLang($id, $lang) {
        $select = $this->select();
        $select->where('lang_id = ?', $lang);
        $select->where('id = ?', $id);

        $row = $this->fetchRow($select);
        if (empty($row)) {
            return false;
        }
        return $row;
    }

    public function findBySlug($slug) {
        $select = $this->select();
        $select->where('slug' . ' = ?', $slug);
        return $this->fetchAll($select);
    }

    public function getRows($filters = array(), $sortField = null, $limit = null, $page = 1) {

        $select = $this->select();
// add any filters which are set
        if (count($filters) > 0) {
            foreach ($filters as $field => $filter) {
                $select->where($field . ' = ?', $filter);
            }
        }
// add the sort field is it is set
        if (null != $sortField) {
            $select->order($sortField);
        }
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        return $adapter;
    }

    public function fetchPaginatorAdapter($filters = array(), $sortField = null) {
        $select = $this->select();
        // add any filters which are set
        if (count($filters) > 0) {
            foreach ($filters as $field => $filter) {
                $select->where($field . ' = ?', $filter);
            }
        }
        // add the sort field is it is set
        if (null != $sortField) {
            $select->order($sortField);
        }
         $select->group ( array ("id") );
        // create a new instance of the paginator adapter and return it
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        return $adapter;
    }

    public function updateRow($id,$lang, $data) {
        $select = $this->select();
        $where['lang_id = ?']= $lang;
        $where['id = ?']=$id;

        $this->update( $data, 'id ='.$id." AND lang_id=".$lang );
    }

    public function deleteRow($id,$lang) {
        $this->delete("id=$id AND lang_id=$lang");
    }
        public function getParentId($id) {
        $row=$this->find($id)->current();
        if ($row) {
           
          return  $row->parent_id;
        } else {
            return false;
        }
    }

    public function getMainCategories() {
        $select = $this->select();
        $select->where('parent_id' . ' = ?', 0);
// add the sort field is it is set
        $select->order('id');
        return $this->fetchAll($select);
    }
      public function getNewRowId()
    {
    	$select=$this->select()->from("categories", array(new Zend_Db_Expr("MAX(id) AS ID")));
    	$row = $this->fetchRow($select);
    	if(empty($row->ID)){return '1';}
    	return $row->ID+1;
    }
}