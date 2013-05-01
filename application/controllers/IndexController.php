<?php

class IndexController extends Zend_Controller_Action
{

     public function indexAction(){

         $users = new Application_Model_DbTable_Users();
         $db    = $users->getAdapter();
         $adapter = new Zend_Paginator_Adapter_DbSelect($db->select()
                 ->from('users'));
         $paginater = new Zend_Paginator($adapter);
         $paginater->setCurrentPageNumber($this->_getParam('page'));
         $paginater->setItemCountPerPage(2);
         $this->view->paginator = $paginater;

     }

    

    public function addAction() {
      
        $request = $this->getRequest();
        
        $form = new Application_Form_User();
         $form->submit->setLabel('Register');
         if ($this->getRequest()->isPost()) {
           
            if ($form->isValid($request->getPost())) {

                $fname      = $form->getValue('fname');
                $lname      = $form->getValue('lname');
                $email      = $form->getValue('email');
                $password   = $form->getValue('password');
                $status     = '1';
                $createdat  = date('d-m-y');
                $updatedat  = date('d-m-y');


                $users = new Application_Model_DbTable_Users();
                $users->addUser($fname, $lname, $email, 
                        $password,$status,
                        $createdat,$updatedat);
               return $this->_helper->redirector('index');
            }
        }
        
        $this->view->form = $form;
    }
    public function editAction(){
        
        $form = new Application_Form_User();
       $form->submit->setLabel('Save');

        $id = $this->_getParam('id', 0);
        $page = $this->_getParam('page');
        $users = new Application_Model_DbTable_Users();
        $form->populate($users->getUsers($id));
        if($this->getRequest()->isPost()){

            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)){
               
                $id         = (int)$form->getValue('id');
                $fname      = $form->getValue('fname');
                $lname      = $form->getValue('lname');
                $email      = $form->getValue('email');
                $password   = $form->getValue('password');
                
                $status     = '1';
                $createdat  = date('d-m-y');
                $updatedat  = date('d-m-y');

                $users = new Application_Model_DbTable_Users();
                 
               $users->updateUser($id, $fname, $lname, $email, $password,
                       $status, $createdat, $updatedat);
               
               $this->_helper->redirector->gotoRouteAndExit(array(
                  'action' => 'index',
                   'page' => $page),  'default', TRUE);

            }

        }
        $this->view->form = $form;
    }

    public function deleteAction(){
        if($this->getRequest()->isPost()){
            $del = $this->getRequest()->getPost('del');
             if ($del == 'Yes'){
                 $id = $this->getRequest()->getPost('id');
                $users = new Application_Model_DbTable_Users();
                $users->deleteUser($id);

             }
             $this->_helper->redirector('index');

        }
         else {
             $id = $this->_getParam('id', 0);
            $users = new Application_Model_DbTable_Users();
            $this->view->user = $users->getUsers($id);

         }
    }
    
    
}

