<?php

namespace Netex\Backend\Forms;

use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Radio;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Url;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Forms\Element\File;

use Netex\Models\Product;

class ProductForm extends Form
{
    public function initialize($entity = null)
    {
        // In edit page the id is hidden
        if (!is_null($entity)) {
            $this->add(new Hidden('id'));
        }

        $value = new Text('name', [
            'placeholder' => 'Name',
            'required'    => 'true',
            'autofocus'   => 'true'
        ]);
        $value->addValidators(
            [
                new PresenceOf([
                    'message' => 'Name is required.'
                ])
            ]
        );
        $this->add($value);

        $this->add(new Select('type', Product::getTypesWithLabels()));
        $this->add(new TextArea('description', ['rows' => 10, 'cols' => 10, 'placeholder' => 'Description']));
        $value = new Text('link', [
            'placeholder' => 'Link',
            'required'    => 'true'
        ]);
        $value->addValidators(
            [
                new PresenceOf([
                    'message' => 'Link is required.'
                ])
            ]
        );
        $this->add($value);

        $value = new Text('price', [
            'placeholder' => 'Price',
            'required'    => 'true'
        ]);
        $value->addValidators(
            [
                new PresenceOf([
                    'message' => 'Price is required.'
                ])
            ]
        );
        $this->add($value);

        $this->add(new File('image'));
        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(
            new Identical(array(
                'value'   => $this->security->getSessionToken(),
                'message' => 'CSRF validation failed'
            ))
        );

        $this->add($csrf);

        //Submit
        $this->add(
            new Submit('save', [
                'value' => 'Save',
                'class' => 'btn btn-sm btn-info'
            ])
        );
    }
}