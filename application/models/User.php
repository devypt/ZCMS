<?php
class Model_User extends Zend_Db_Table_Abstract
{
protected $_name = 'users';


public function addRow($data)
{
	$row = $this->createRow();
	foreach($data as $k=>$v)
	{
		$row->$k=$v;
	}
	$row->save();
	// now fetch the id of the row you just created and return it
	$id = $this->_db->lastInsertId();
	return $id;
}

public function email_exists($email)
{
   $wheres = "email= '$email'";
$all = $this->fetchAll($wheres)->toArray();
if(empty($all))
{
    return false;
}
return true;

}
public function email_duplicated($email)
{
   $wheres = "email= '$email'";
$all = $this->fetchAll($wheres)->toArray();
if(count($all)==1)
{
    return false;
}
return true;

}
public function username_exists($username)
{
   $wheres = "username= '$username'";
$all = $this->fetchAll($wheres)->toArray();
if(empty($all))
{
    return false;
}
return true;

}
public function getRows($filters = array(), $sortField = null, $limit = null,$page=1)
{
	
		$select = $this->select();
// add any filters which are set
if(count($filters) > 0) {
foreach ($filters as $field => $filter) {
$select->where($field . ' = ?', $filter);
}
}
// add the sort field is it is set
if(null != $sortField) {
$select->order($sortField);
}
$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
return $adapter;
	
	
	
}

public function fetchPaginatorAdapter($filters = array(), $sortField = null)
{
	$select = $this->select();
	// add any filters which are set
	if(count($filters) > 0) {
		foreach ($filters as $field => $filter) {
			$select->where($field . ' = ?', $filter);
		}
	}
	// add the sort field is it is set
	if(null != $sortField) {
		$select->order($sortField);
	}
	// create a new instance of the paginator adapter and return it
	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
	return $adapter;
	}
	
	
	public function updateRow($id,$data)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();
		if($row) {
			foreach($data as $k=>$v)
			{
				$row->$k=$v;
			}
			// save the updated row
			$row->save();
			return true;
		} else {
			throw new Zend_Exception("Update function failed; could not find row!");
		}
	}
	
	public function deleteRow($id)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();
		if($row) {
			$row->delete();
			return true;
		} else {
		return false;
		}
	}
	
	

}
?>
