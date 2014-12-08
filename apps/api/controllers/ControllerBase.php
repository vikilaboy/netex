<?php

namespace Netex\Api\Controllers;

use Netex\Models\Customer;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    /**
     * @var bool
     */
    protected $jsonResponse = true;

    /**
     * @var array
     */
    public $jsonMessages = [];

    /**
     * Check if we need to throw a json respone. For ajax calls.
     *
     * @return bool
     */
    public function isJsonResponse()
    {
        return $this->jsonResponse;
    }

    /**
     * Set a flag in order to know if we need to throw a json response.
     *
     * @return $this
     */
    public function setJsonResponse()
    {
        $this->jsonResponse = true;
        return $this;
    }

    public function beforeExecuteRoute()
    {
        return $this->authorization();
    }

    /**
     * After execute route event
     *
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        if ($this->isJsonResponse()) {
            $this->response->setContentType('application/json', 'UTF-8');

            $data = $dispatcher->getReturnedValue();

            if (is_array($data)) {
                $this->response->setJsonContent($data);
            }
            echo $this->response->getContent();
        }
    }

    public function show404Action()
    {
        return [
            'error'    => true,
            'code'     => 404,
            'messages' => ['Route not found'],
            'results'  => []
        ];
    }

    private function authorization()
    {
        $user = $this->request->getHeader('X_HTTP_AUTH_USER'); // email
        $apiKey = $this->request->getHeader('X_HTTP_AUTH_KEY'); // apiKey
        $hash = $this->request->getHeader('X_HTTP_AUTH_HASH'); // sha1 computed hash

        if (empty($user) || empty($apiKey) || empty($hash)) {
            $this->response->setContentType('application/json', 'UTF-8');

            $this->response->setJsonContent([
                'error'    => true,
                'code'     => 401,
                'messages' => ['Unauthorized. Authentication headers not provied.'],
                'results'  => []
            ]);
            echo $this->response->getContent();
            return false;
        }

        $customer = Customer::findFirstByEmail($user);

        if (!$customer) {
            $this->response->setJsonContent([
                'error'    => true,
                'code'     => 401,
                'messages' => ['Username does\'t exist.'],
                'results'  => []
            ]);

            echo $this->response->getContent();
            return false;
        }

        if ($customer->getApikey() !== $apiKey) {
            $this->response->setJsonContent([
                'error'    => true,
                'code'     => 401,
                'messages' => ['AUTH_KEY invalid.'],
                'results'  => []
            ]);

            echo $this->response->getContent();
            return false;
        }

        if ($hash != sha1($this->request->getRawBody() . $customer->getPasswd())) {
            $this->response->setJsonContent([
                'error'    => true,
                'code'     => 401,
                'messages' => ['AUTH_HASH invalid.'],
                'results'  => []
            ]);

            echo $this->response->getContent();
            return false;
        }
    }
}
