<?php

namespace Netex\Backend\Controllers;

use \Phalcon\Tag;
use Phalcon\Mvc\View;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    /**
     * Executes after instance
     */
    public function initialize()
    {
        $this->loadDefaultAssets();

        if ($this->request->isAjax()) {
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }
        $this->view->setTemplateBefore('layout');

        Tag::setTitle('Netex Shop Management | ' . ucwords($this->router->getControllerName()));
    }

    /**
     * loadDefaultAssets method.
     *
     * @access private
     * @return void
     */
    private function loadDefaultAssets()
    {
        $this->assets
            ->addCss('//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css', false)
            ->addCss('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', false)
            ->addCss('../css/realia-blue.css')
            ->addCss('../css/jumbotron-narrow.css')
            ->addCss('../css/custom.css');
        ;

        $this->assets
            ->addJs('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', false)
            ->addJs('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js', false)
            ->addJs('//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', false)
            ->addJs('../js/jquery.lazyload.min.js');
    }

    public function toggleObject($id, $class, $method = 'active')
    {
        $class = 'Netex\Models\\' . ucfirst($class);
        if (!class_exists($class)) {
            return false;
        }

        $object = $class::findFirst('id="' . (int)$id . '"');

        if (!is_object($object)) {
            return false;
        }
        $setter = 'set' . $method;
        $getter = 'get' . $method;

        if (!method_exists($object, $getter) || !method_exists($object, $setter)) {
            return false;
        }
        $value = $object->$getter() == 0 ? 1 : 0;
        $object->$setter($value);

        return $object->save();

    }

    /**
     * Method to delete objects
     *
     * @return mixed
     */
    public function delete($id)
    {
        $class = 'Netex\Models\\' . ucfirst($this->router->getControllerName());

        if (!class_exists($class)) {
            return false;
        }

        $id = $this->filter->sanitize($id, ['int']);

        $object = $class::findFirstById($id);
        if (!$object) {
            $this->flash->error('Entry was not found');
            return $this->response->redirect($this->request->getHTTPReferer(), true);
        }

        if (!$object->delete()) {
            foreach ($object->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }
        } else {
            $this->flash->success('Entry was successfully deleted');
        }
        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }

    public function show404Action()
    {
        return $this->view->pick('partials/show404');
    }
}