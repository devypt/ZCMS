<?php

class My_View_Helper_Lang extends Zend_View_Helper_Abstract {

    function Lang($id) {
        $langs = new Model_Lang();
        $contenModel = new Model_Content();
        foreach ($langs->fetchAll() as $row) {
            $content = $contenModel->isContentExistForLang($id, $row->id);

            if (!$content) {
                echo "<td><a href='".$this->view->url(array('module'=>'content','controller'=>'admin','action'=>'add','id'=>$id,'lang'=>$row->id)). "'><span class='add'></span></a></td>";
            } else {

                $is_active = "<a href='" .$this->view->url(array('module'=>'content','controller'=>'admin','action'=>'isactive','id'=>$id,'lang'=>$row->id,'value'=>$content->is_active)). "'>";
                if ($content->is_active == 0) {
                    $is_active.='<span class="ui-icon ui-icon-bullet"></span>';
                } else {
                    $is_active.='<span class="ui-icon ui-icon-check"></span>';
                }
                $is_active.="</a>";
                echo "<td>$is_active<a href='".$this->view->url(array('module'=>'content','controller'=>'admin','action'=>'view','id'=>$id)). "'><span class='view'>&nbsp;</span></a>
<a href='".$this->view->url(array('module'=>'content','controller'=>'admin','action'=>'edit','id'=>$id,'lang'=>$row->id)). "'><span class='edit'></span></a><a href='".$this->view->url(array('module'=>'content','controller'=>'admin','action'=>'delete','id'=>$id,'lang'=>$row->id)) . "'><span class='delete'>&nbsp;</span></a></td>";
            }
        }
    }

}