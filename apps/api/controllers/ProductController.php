<?php

namespace Netex\Api\Controllers;

use Netex\Models\Product;
use Phalcon\Exception;
use Phalcon\Image\Adapter\Imagick;

class ProductController extends ControllerBase
{
    public function indexAction()
    {
        if (!$this->request->isGet()) {
            return [
                'error'    => false,
                'code'     => '400',
                'messages' => [
                    'Bad request.'
                ],
                'results'  => []
            ];
        }
        return [

            'error'    => false,
            'code'     => 200,
            'messages' => [
            ],
            'results'  => Product::find()->toArray()
        ];
    }

    public function addAction()
    {
        if (!$this->request->isPost()) {
            return [
                'error'    => false,
                'code'     => '400',
                'messages' => [
                    'Bad request.'
                ],
                'results'  => []
            ];
        }
        $product = new Product();
        if ($product->save($this->request->getPost())) {
            if (!empty($this->request->getPost('image'))) {
                $file = $this->base64ToJpeg($this->request->getPost('image'), $product->getId() . '-original');

                $image = new Imagick(PRODUCT_IMAGE_DIR . 'original/' . $file);
                $image->resize(500, 500);
                try {
                    $image->save(PRODUCT_IMAGE_DIR . $product->getId() . '.jpg');
                } catch (\Exception $e) {
                    return [
                        'error'    => false,
                        'code'     => '200',
                        'messages' => [
                            'Product image was not saved successfully.'
                        ],
                        'results'  => []
                    ];
                }
            }
            return [
                'error'    => false,
                'code'     => '200',
                'messages' => [
                    'Product added successfully.'
                ],
                'results'  => []
            ];
        } else {
            $messages = [];
            foreach ($product->getMessages() as $message) {
                $messages[] = $message->getMessage();
            }
            return [
                'error'    => true,
                'code'     => '200',
                'messages' => $messages,
                'results'  => []
            ];
        }
    }

    public function editAction()
    {
        if (!$this->request->isPut()) {
            return [
                'error'    => false,
                'code'     => '400',
                'messages' => [
                    'Bad request.'
                ],
                'results'  => []
            ];
        }
        $product = Product::findFirstById($this->request->getPut('id'));
        if (!$product) {
            return [
                'error'    => true,
                'code'     => '404',
                'messages' => [
                    'Product not found.'
                ],
                'results'  => []
            ];
        }
        /*
        //if method doesn't exists we can throw and error - BatMethodCallException.
        foreach ($this->request->getPut() as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($product, $method)) {
                $product->$method($value);
            }
        }
        */
        if ($product->update($this->request->getPut())) {
            if (!empty($this->request->getPut('image'))) {
                $file = $this->base64ToJpeg($this->request->getPut('image'), $product->getId() . '-original');
                try {
                    $image = new Imagick(PRODUCT_IMAGE_DIR . 'original/' . $file);
                    $image->resize(500, 500);
                    $image->save(PRODUCT_IMAGE_DIR . $product->getId() . '.jpg');
                } catch (Exception $e) {
                    return [
                        'error'    => false,
                        'code'     => '200',
                        'messages' => [
                            'Product image was not saved successfully. Exception : ' //. $e->getMessage()
                        ],
                        'results'  => []
                    ];
                }
            }
            return [
                'error'    => false,
                'code'     => '200',
                'messages' => [
                    'Product saved successfully.'
                ],
                'results'  => []
            ];
        } else {
            $messages = [];
            foreach ($product->getMessages() as $message) {
                $messages[] = $message->getMessage();
            }
            return [
                'error'    => true,
                'code'     => '404',
                'messages' => $messages,
                'results'  => []
            ];
        }
    }

    public function deleteAction($id)
    {
        if (!$this->request->isDelete()) {
            return [
                'error'    => true,
                'code'     => '400',
                'messages' => [
                    'Bad request.'
                ],
                'results'  => []
            ];
        }
        if (!$product = Product::findFirstById((int)$id)) {
            return [
                'error'    => true,
                'code'     => '400',
                'messages' => [
                    'Product doesn\'t exist.'
                ],
                'results'  => []
            ];
        } elseif (!$product->delete()) {
            $messages = [];
            foreach ($product->getMessages() as $message) {
                $messages[] = $message->getMessage();
            }
            return [
                'error'    => true,
                'code'     => '400',
                'messages' => $messages,
                'results'  => []
            ];
        } else {
            @unlink(PRODUCT_IMAGE_DIR . $id . '.jpg');
            @unlink(PRODUCT_IMAGE_DIR . 'original' . DS . $id . '-original.jpg');
            return [
                'error'    => false,
                'code'     => '200',
                'messages' => [
                    'Product deleted successfully'
                ],
                'results'  => []
            ];
        }
    }

    private function base64ToJpeg($base64String, $outputFile = null,  $path = null, $extension = '.jpg')
    {
        if (empty($outputFile)) {
            $outputFile = md5(microtime()) . $extension;
        } else {
            $outputFile .= $extension;
        }

        if (empty($path)) {
            $path = PRODUCT_IMAGE_DIR . 'original/';
        }

        $ifp = fopen($path . $outputFile, "wb");

        $data = explode(',', $base64String);

        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);

        return $outputFile;
    }
}