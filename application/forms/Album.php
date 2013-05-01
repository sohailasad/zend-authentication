<?php
class Application_Form_Album extends Zend_Form
{
    public function init()
    {
        $this->setName('album');
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        $artist = new Zend_Form_Element_Text('artist');
        $artist->setLabel('Add Artist :')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addFilter('Alpha', array('allowWhiteSpace' => true))
            ->addFilter('HtmlEntities')
            ->addValidator('NotEmpty');


        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Add Title :')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addFilter('Alpha', array('allowWhiteSpace' => true))
            ->addFilter('HtmlEntities')
            ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $this->addElements(array($id, $artist, $title, $submit));
    }
}