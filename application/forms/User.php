<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_User extends Zend_Form{

    public function init()
    {
        $this->setName('user');
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $fname = new Zend_Form_Element_Text('fname');
        $fname->setLabel('First Name :')
                //->addValidator('stringLength', FALSE, array(6,20))
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim','StringToLower')

            ->addFilter('Alpha', array('allowWhiteSpace' => FALSE));
               
        $lname = new Zend_Form_Element_Text('lname');
        $lname->setLabel('Last Name :')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addFilter('Alpha', array('allowWhiteSpace' => true))
            ->addFilter('HtmlEntities')
            ->addValidator('NotEmpty');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email :')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            //->addFilter('Alpha', array('allowWhiteSpace' => FALSE))
            ->addFilter('HtmlEntities')
            ->addValidator('EmailAddress');

        


        $password = new Zend_Form_Element_Text('password','password');
        $password->setLabel('Password :')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            //->addFilter('Alpha', array('allowWhiteSpace' => true))
            ->addFilter('HtmlEntities')
             ->addValidator('stringLength', FALSE, array(6,20));



        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array(
            $id, $fname, $lname,$email, $password, $submit
            ));
    }
}