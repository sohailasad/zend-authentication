<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract{



    /** Table name */
    protected $_name    = 'users';

    public function getUsers($id){
        $id = (int)$id;
        $row = $this->fetchRow('id = '.$id);
        if(!$row){
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function addUser($fname, $lname, $email, $password, $status,
            $createdat, $updatedat)
    {
        $data = array(
            'fname'     => $fname,
            'lname'     => $lname,
            'email'     => $email,
            'password'  => $password,
            'status'    => $status,
            'createdat' => $createdat,
            'updatedat' => $updatedat
        );
        $this->insert($data);
    }
    public function updateUser($id, $fname, $lname, $email, $password, $status,
            $createdat,$updatedat ) {
        $data = array(
            'fname'     => $fname,
            'lname'     => $lname,
            'email'     => $email,
            'password'  => $password,
            'status'    => $status,
            'createdat' => $createdat,
            'updatedat' => $updatedat

        );
        return $this->update($data, 'id ='.(int)$id);

    }
    public function deleteUser($id)
    {
        return $this->delete('id =' . (int)$id);
    }

}