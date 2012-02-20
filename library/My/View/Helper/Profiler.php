<?php
class My_View_Helper_Categorylang extends Zend_View_Helper_Abstract
{
	function Categorylang($id)
	{
		$langs=new Model_Lang();
                $contenModel=new Model_Category();
                foreach($langs->fetchAll() as $row)
                {
               $category=$contenModel->isCategoryExistForLang($id,$row->id);
                
                   if(!$category)
                   {
                    echo "<td><a href='/content/admin/addcategory/id/".$id."/lang/".$row->id."'><span class='add'></span></a></td>";   
                   }else{
                   
  $is_active="<a href='/content/admin/categoryisactive/id/".$id."/lang/".$row->id."/value/".$category->is_active."'>";
  if($category->is_active==0){
$is_active.='<span class="ui-icon ui-icon-bullet"></span>';
}else{
$is_active.='<span class="ui-icon ui-icon-check"></span>';
}
 $is_active.="</a>";                      
echo "<td>$is_active<a href='/content/admin/viewcategory/id/".$id."/lang/".$row->id."'><span class='view'>&nbsp;</span></a>
<a href='/content/admin/editcategory/id/".$id."/lang/".$row->id."'><span class='edit'></span></a><a href='/content/admin/deletecategory/id/".$id."/lang/".$row->id."'><span class='delete'>&nbsp;</span></a></td>";    
                   }
                }
	}
        
}