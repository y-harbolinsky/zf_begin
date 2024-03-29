<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $this->view->title = "My Albums";
        $this->view->headTitle($this->view->title);

        $albums = new Application_Model_DbTable_Albums();
        $this->view->albums = $albums->fetchAll();
    }

    public function helloAction()
    {
        // action body
        echo "hello";
    }

    public function addAction()
    {
        // action body
        $this->view->title = "Add new album";
        $this->view->headTitle($this->view->title);

        $form = new Application_Form_Album();
        $form->submit->setLabel('Додати');
        $this->view->form = $form;

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $albums = new Application_Model_DbTable_Albums();
                $albums->addAlbum($artist, $title);

                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        // action body
        $this->view->title = "Edit album";
        $this->view->headTitle($this->view->title);

        $form = new Application_Form_Album();
        $form->submit->setLabel('Save');
        $this->view->form = $form;

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $albums = new Application_Model_DbTable_Albums();
                $albums->updateAlbum($id, $artist, $title);

                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if($id > 0) {
                $albums = new Application_Model_DbTable_Albums();
                $form->populate($albums->getAlbum($id));
            }
        }
    }

    public function deleteAction()
    {
        // action body
        $this->view->title = "Delete album";
        $this->view->headTitle($this->view->title);

        if($this->getRequest()->isPost()) {
            if($del = 'Да') {
                $id = $this->getRequest()->getPost('id');
                $albums = new Application_Model_DbTable_Albums();
                $albums->deleteAlbum($id);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $albums = new Application_Model_DbTable_Albums();
            $this->view->album = $albums->getAlbum($id);
        }
    }


}







