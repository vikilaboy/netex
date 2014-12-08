<?php

namespace Netex\Models;

use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\Inclusionin;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Customer extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @var string
     */
    protected $passwd;

    /**
     *
     * @var string
     */
    protected $apiKey;

    /**
     *
     * @var integer
     */
    protected $status;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field passwd
     *
     * @param string $passwd
     *
     * @return $this
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;

        return $this;
    }

    /**
     * Method to set the value of field apiKey
     *
     * @param string $apiKey
     *
     * @return $this
     */
    public function setApikey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field passwd
     *
     * @return string
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Returns the value of field apiKey
     *
     * @return string
     */
    public function getApikey()
    {
        return $this->apiKey;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Validations and business logic
     */
    public function validation()
    {
        $this->validate(
            new Email(
                [
                    'field'    => 'email',
                    'required' => true,
                ]
            )
        );

        $this->validate(
            new Uniqueness(
                [
                    "field"   => 'email',
                    "message" => "Another user with same email already exists."
                ]
            )
        );

        $this->validate(
            new Uniqueness(
                [
                    "field"   => 'apiKey',
                    "message" => "Another user with same apiKey already exists."
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    public function getSource()
    {
        return 'customer';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return [
            'id'     => 'id',
            'name'   => 'name',
            'email'  => 'email',
            'passwd' => 'passwd',
            'apiKey' => 'apiKey',
            'status' => 'status'
        ];
    }
}
