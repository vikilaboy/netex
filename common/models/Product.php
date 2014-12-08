<?php

namespace Netex\Models;

use Phalcon\Mvc\Model\Validator\Inclusionin;

class Product extends \Phalcon\Mvc\Model
{

    const TYPE_WINTER = 'W';
    const TYPE_SUMMER = 'S';
    const TYPE_ALL_SEASON = 'A';

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $link;

    /**
     *
     * @var double
     */
    protected $price;

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
     * Method to set the value of field type
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * Method to set the value of field description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field link
     *
     * @param string $link
     *
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Method to set the value of field price
     *
     * @param double $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

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
     * Returns the value of field type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the value of field link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    public function getImage()
    {
        // @TODO : constant. absolut path, relative path.
        $path = '/img/p/' . $this->getId() . '.jpg';
        if (file_exists(PUBLIC_DIR . $path)) {
            return $path;
        }

        return '/img/a0.png';
    }

    /**
     * Returns the value of field price
     *
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function getSource()
    {
        return 'product';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return [
            'id'          => 'id',
            'type'        => 'type',
            'name'        => 'name',
            'description' => 'description',
            'link'        => 'link',
            'price'       => 'price'
        ];
    }

    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }

    /**
     * Validations and business logic
     */
    public function validation()
    {
        $this->validate(
            new Inclusionin(
                [
                    'field'   => 'type',
                    'message' => 'The type is invalid.',
                    'domain'  => array_flip(self::getTypesWithLabels())
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    public static function getTypesWithLabels()
    {
        return [
            self::TYPE_WINTER => 'Winter',
            self::TYPE_SUMMER => 'Summer',
            self::TYPE_ALL_SEASON => 'All season'
        ];
    }
}
