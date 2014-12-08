<?php

namespace Netex\Frontend\Controllers;

use Netex\Models\Product;

class ProductController extends ControllerBase
{
    public function itemAction($id)
    {
        $product = Product::findFirstById($id);
        if (!$product) {
            $this->dispatcher->forward(array(
                'controller' => 'product',
                'action' => 'show404'
            ));
            return false;
        }
        $this->view->setVar('object', $product);

        return $this->view->pick('product/item');
    }
}

