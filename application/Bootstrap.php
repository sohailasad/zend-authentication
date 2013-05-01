<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    // To add a bootstrap resource start with _init
    protected function _initView()
    {
        // Initialize view
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('My First Zend Framework Application');

        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);

        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

    // to initialize the doctype
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $view->setEncoding('UTF-8');
    }


    protected function _initStylesheets()
    {
        $this->view->headLink()->appendStylesheet('/sys/styles/reset.css');
        $this->view->headLink()->appendStylesheet('/sys/styles/style.css');
    }

    protected function _initJavascripts()
    {
        $this->view->headScript()->appendFile('/sys/js/prototype.js');
    }
    


}

