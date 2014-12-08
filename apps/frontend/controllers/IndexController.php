<?php

namespace Netex\Frontend\Controllers;

use Netex\Models\Product;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $conditions = null;
        if ($this->request->getPost('search') && !empty($this->request->getPost('search'))) {

            $conditions = [
                'conditions' => 'name LIKE :name:',
                'bind'       => ['name' => '%' . $this->request->getPost('search', 'striptags') . '%']
            ];
            $this->view->setVar('search', $this->request->getPost('search', 'striptags'));
        }
        $conditions['order'] = 'id DESC';
        $items = Product::find($conditions);
        $this->view->setVar('items', $items);
    }

    public function itemAction($id)
    {

    }
}

