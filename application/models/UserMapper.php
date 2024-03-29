<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_UserMapper
{


    protected $_dbTable;

	        public function setDbTable($dbTable)
	        {
	            if (is_string($dbTable)) {
	                $dbTable = new $dbTable();
	            }
	            if (!$dbTable instanceof Zend_Db_Table_Abstract) {
	                throw new Exception('Invalid table data gateway provided');
	            }
	            $this->_dbTable = $dbTable;
	            return $this;
	        }

	        public function getDbTable()
	        {
	            if (null === $this->_dbTable) {
	                $this->setDbTable('Application_Model_DbTable_Users');
	            }	            return $this->_dbTable;
	        }

	        public function save(Application_Model_User $user)
	        {
	            $data = array(
	                'fname'   => $user->getFname(),
	                'lname' => $user->getLname(),
                        'email'   => $user->getEmail(),
	                'password' => $user->getPassword(),
                       // 'status'   => $user->getStatus(),

	                'createdat' => date('Y-m-d H:i:s'),
                        'updatedat' => date('Y-m-d H:i:s')
	            );

	            if (null === ($id = $user->getId())) {
	                unset($data['id']);
	                $this->getDbTable()->insert($data);
	            } else {
	                $this->getDbTable()->update($data, array('id = ?' => $id));
	            }
	        }

            public function find($id, Application_Model_User $guestbook)
	        {
	            $result = $this->getDbTable()->find($id);
	            if (0 == count($result)) {
	                return;
	            }
	            $row = $result->current();
	            $user->setId($row->id)
	                      ->setFname($row->fname)
	                      ->setLname($row->lname)
	                      ->setEmail($row->email)
                              ->setPassword($row->password)
                              ->setStatus($row->status)
                              ->setCreated($row->createdat)
                              ->setUpdated($row->updatedat);
	        }

	        public function fetchAll()
	        {
	            $resultSet = $this->getDbTable()->fetchAll();
	            $entries   = array();
	            foreach ($resultSet as $row) {
	                $entry = new Application_Model_User();
	                $entry->setId($row->id)
	                       ->setFname($row->fname)
	                      ->setLname($row->lname)
	                      ->setEmail($row->email)
                              ->setPassword($row->password)
                              ->setStatus($row->status)
                              ->setCreated($row->createdat)
                              ->setUpdated($row->updatedat);
	                $entries[] = $entry;
	            }
	            return $entries;
	        }
}