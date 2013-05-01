<?php

class AlbumController extends Zend_Controller_Action {

    public function indexAction() {
        
         $albums = new Application_Model_DbTable_Albums();
        $db = $albums->getAdapter();
// use join table
        $select = $db->select()
           ->from('albums')
           ->join('users','albums.user_id = users.id',array('fname'));
        
        $adapter = new Zend_Paginator_Adapter_DbSelect($select);

        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(3);
        $this->view->paginator = $paginator;
     }

     public function preDispatch()
    {
         
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            
            // If the user is logged in, we don't want to show the login form;
            // however, the logout action should still be available
            if ('logout' != $this->getRequest()->getActionName()) {

                $this->_helper->redirector('index','login');
            }
        } else {
            // If they aren't, they can't logout, so that action should
            // redirect to the login form
            if ('logout' == $this->getRequest()->getActionName()) {

                $this->_helper->redirector('index','index');
            }
        }
    }
    
    function addAction() {
        
//        if(Zend_Auth::getInstance()->hasIdentity())
//                {

                   $request = $this->getRequest();
                    $form = new Application_Form_Album();

                    $form->submit->setLabel('Add');
                    $this->view->form = $form;
                    if ($this->getRequest()->isPost()) {
                        $formData = $this->getRequest()->getPost();
                        if ($form->isValid($formData)) {
                            $artist = $form->getValue('artist');
                            $title = $form->getValue('title');
                            $albums = new Application_Model_DbTable_Albums();
                            $albums->addAlbum($artist, $title);
                            $this->_helper->redirector('index','album');
                        } else {
                            $form->populate($formData);
                        }
                    }
//                }
//                else
//                {
//                    $this->_helper->redirector('index','login');
//                }

        
    }
    public function editAction(){

        $form = new Application_Form_Album();
        $form->submit->setLabel('Save Album');

        $id = $this->_getParam('id', 0);
        $page = $this->_getParam('page');
        $albums = new Application_Model_DbTable_Albums();
        $form->populate($albums->getAlbum($id));
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)){
                $id     = (int)$form->getValue('id');
                $artist = $form->getValue('artist');
                $title  = $form->getValue('title');
                
                
                $albums = new Application_Model_DbTable_Albums();
               $albums->updateAlbum($id, $artist, $title);
               $this->_helper->redirector->gotoRouteAndExit(array(
                  'action' => 'index',
                   'page' => $page),  'default', FALSE);

            }

        }
        $this->view->form = $form;
    }

    public function deleteAction(){
        $id = $this->getRequest()->getPost('id');
        $album = new Application_Model_DbTable_Albums();
        if($album->deleteAlbum($id))
        {
            echo json_encode(array('message'=>'success',
                'info'=>'user deleted successfully'));
        }
        else
        {
            echo json_encode(array('message'=>'failure',
                'info'=>'user cannot be deleted'));
        }
        exit;

//        if($this->getRequest()->isPost()){
//            $del = $this->getRequest()->getPost('del');
//             if ($del == 'Yes'){
//                 $id = $this->getRequest()->getPost('id');
//                $album = new Application_Model_DbTable_Albums();
//                $album->deleteAlbum($id);
//
//             }
//             $this->_helper->redirector('index');
//
//        }
//         else {
//             $id = $this->_getParam('id', 0);
//            $albums = new Application_Model_DbTable_Albums();
//            $this->view->album = $albums->getAlbum($id);
//
//         }
    }

}

