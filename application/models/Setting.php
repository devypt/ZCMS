<?php

class Model_Setting extends Zend_Db_Table_Abstract {

    protected $_name = 'settings';
    protected $_primary = 'lang_id';

    public function addRow($data) {


        $row = $this->createRow();
        foreach ($data as $k => $v) {
            $row->$k = $v;
        }

        $row->save();
        return true;
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

    public function updateRow($lang_id, $data) {
        $select = $this->select();
        $this->update( $data, "lang_id=".$lang_id );
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
    public function getSiteName($lang_id)
    {
       $row=$this->find($lang_id)->current();
       return $row->site_name;
    }
     public function getSiteDescription($lang_id)
    {
       $row=$this->find($lang_id)->current();
       return $row->site_description;
    }
    
     public function getSiteKeywords($lang_id)
    {
       $row=$this->find($lang_id)->current();
       return $row->site_keywords;
    }
}