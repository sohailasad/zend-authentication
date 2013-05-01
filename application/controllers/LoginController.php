<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class LoginController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
        $form = $this->getForm();

        if($this->getRequest()->isPost())
        { 
            if($form->isValid($this->getRequest()->getPost()))
            {
                $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

                $authAdapter
                    ->setTableName('users')
                    ->setIdentityColumn('fname')
                    ->setCredentialColumn('password');
// to check status
                $select = $authAdapter->getDbSelect();
                $select->where('status = "Active"');
                
                    

                $authAdapter
                    ->setIdentity($form->getValue('username'))
                    ->setCredential($form->getValue('password'));

                $auth = Zend_Auth::getInstance();
               $result = $auth->authenticate($authAdapter);

                
                if($result->isValid())
                {
// to store values in session
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(null,array('password')));
                    $this->_helper->redirector('index','album');
                }
                else
                {
                    die("invalid login");
                }
                
            }
        } 
        $this->view->form = $form;
    }
    public function preDispatch()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            // If the user is logged in, we don't want to show the login form;
            // however, the logout action should still be available
            if ('logout' != $this->getRequest()->getActionName()) {

                $this->_helper->redirector('index','index');
            }
        } else {
            // If they aren't, they can't logout, so that action should
            // redirect to the login form
            if ('logout' == $this->getRequest()->getActionName()) {
                $this->_helper->redirector('index');
            }
        }
    }
    public function getForm()
    {
        
        return new Application_Form_Login(array(
            'method' => 'post',
        ));
    }

    public function getAuthAdapter(array $params)
    {
        // Leaving this to the developer...
        // Makes the assumption that the constructor takes an array of
        // parameters which it then uses as credentials to verify identity.
        // Our form, of course, will just pass the parameters 'username'
        // and 'password'.
    }

    

    public function processAction()
    {
        $request = $this->getRequest();

        // Check if we have a POST request
        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }

        // Get our form and validate it
        $form = $this->getForm();
        if (!$form->isValid($request->getPost())) {
            // Invalid entries
            $this->view->form = $form;
            return $this->render('index'); // re-render the login form
        }

        // Get our authentication adapter and check credentials
        $adapter = $this->getAuthAdapter($form->getValues());
        $auth    = Zend_Auth::getInstance();
        $result  = $auth->authenticate($adapter);
        if (!$result->isValid()) {
            // Invalid credentials
            $form->setDescription('Invalid credentials provided');
            $this->view->form = $form;
            return $this->render('index'); // re-render the login form
        }

        // We're authenticated! Redirect to the home page
        $this->_helper->redirector('index', 'index');
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
	  $auth->clearIdentity();
        //Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index','login'); // back to login page
    }
   
}
