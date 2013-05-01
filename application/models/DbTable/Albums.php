<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_DbTable_Albums extends Zend_Db_Table_Abstract
{
     // Table name
    protected $_name= 'albums';

    public function getAlbum($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
        throw new Exception("Could not find row $id");
        }
        return $row->toArray();

    }
    public function addAlbum($artist, $title)
    {
        $auth = Zend_Auth::getInstance();
        $userId= $auth->getIdentity()->id; 

        $data = array(
        'artist' => $artist,
        'title' => $title,
            'user_id' => $userId
        );
        return $this->insert($data);
    }
    public function updateAlbum($id, $artist, $title)
    {
        $data = array(
        'artist' => $artist,
        'title' => $title,
        );
        return $this->update($data, 'id = '. (int)$id);
    }
    public function deleteAlbum($id)
    {
        return $this->delete('id =' . (int)$id);
    }
}