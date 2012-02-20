<?php
class My_View_Helper_Lang extends Zend_View_Helper_Abstract
{
	function Lang($id)
	{
		$langs=new Model_Lang();
                $contenModel=new Model_Content();
                foreach($langs->fetchAll() as $row)
                {
                    $content=$contenModel->isContentExistForLang($id,$row->id);
                
                   if(!$content)
                   {
                    echo "<td><a href='/content/admin/add/id/".$id."/lang/".$row->id."'><span class='add'></span></a></td>";   
                   }else{
                   
  $is_active="<a href='/content/admin/isactive/id/".$id."/lang/".$row->id."/value/".$content->is_active."'>";
  if($content->is_active==0){
$is_active.='<span class="ui-icon ui-icon-bullet"></span>';
}else{
$is_active.='<span class="ui-icon ui-icon-check"></span>';
}
 $is_active.="</a>";                      
echo "<td>$is_active<a href='/content/admin/view/id/".$id."/lang/".$row->id."'><span class='view'>&nbsp;</span></a>
<a href='/content/admin/edit/id/".$id."/lang/".$row->id."'><span class='edit'></span></a><a href='/content/admin/delete/id/".$id."/lang/".$row->id."'><span class='delete'>&nbsp;</span></a></td>";    
                   }
                }
	}
        
}