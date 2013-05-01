<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_AlbumMapper extends Zend_Paginator_Adapter_DbSelect{

    public function fetchOutstanding()

    {

       $db = $this->getDbAdapter();

        $select = $db->select();

        $select->from($this->_albums);

        $select->where('date_completed IS NULL');

        $select->order(array('date_completed DESC', 'id DESC'));



        $adapter = new Zend_Paginator_Adapter_DbSelect($select);

        $paginator = new Zend_Paginator($adapter);

        return $paginator;

    }


}
