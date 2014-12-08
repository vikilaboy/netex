<?php

namespace Netex\Backend\Controllers;

use Netex\Backend\Forms\ProductForm;
use Netex\Models\Product;
use \Phalcon\Mvc\Controller;
use \Phalcon\Mvc\View;
use \Phalcon\Paginator\Adapter\Model;
use \Phalcon\Tag;
use \Phalcon\Mvc\Model\Criteria;
use \Phalcon\Utils\Slug;
use Phalcon\Image\Adapter\Imagick;

class ProductController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->setVars(
            [
                'items' => Product::find(),
                'grid'  => [
                    'id'    => [
                        'title' => 'Id',
                        'order' => true
                    ],
                    'type'  => [
                        'title'  => 'Tip',
                        'order'  => true,
                        'filter' => [
                            'type'     => 'select',
                            'sanitize' => 'int',
                            'values'   => Product::getTypesWithLabels(),
                            'using'    => null,
                            'style'    => 'width: 100px;'
                        ]
                    ],
                    'name'  => [
                        'title'  => 'Nume',
                        'order'  => true,
                        'filter' => ['type' => 'input', 'sanitize' => 'string', 'style' => '']
                    ],
                    'price' => [
                        'title'  => 'Pret',
                        'order'  => true,
                        'filter' => ['type' => 'input', 'sanitize' => 'float', 'style' => '']
                    ]
                ]
            ]);

    }

    public function mockAction()
    {
        $this->view->disable();

        $availableFiles = scandir(PUBLIC_DIR . 'mock');
        foreach ($availableFiles as $k => &$filename) {
            //exclude .  ..  .svn and index.php and all hidden files
            if (preg_match('/^\..*|index\.php/i', $filename)) {
                unset($availableFiles[$k]);
            } else {
                $filename = PUBLIC_DIR . 'mock' . DS . $filename;
            }
        }
        unset($filename);

        $types = ['W' => 'W', 'S' => 'S', 'A' => 'A'];

        $names   = [
            'Anvelope Iarna CONTINENTAL ContiWinterContact TS 850 205/55 R16 91 H',
            'Anvelope Iarna CONTINENTAL ContiWinterContact TS 850 195/65 R15 91 T',
            'Anvelope Iarna CONTINENTAL ContiWinterContact TS 850 185/65 R15 88 T',
            'Anvelope All Seasons CONTINENTAL ContiCrossContact LX 215/65 R16 98 H',
            'Anvelope Vara CONTINENTAL ContiSportContact 5 225/45 R17 91 Y',
            'Anvelope Iarna CONTINENTAL Conti4x4WinterContact 265/65 R17 112 T',
            'Anvelope Vara CONTINENTAL ContiEcoContact CP 185/60 R14 82 H',
            'Anvelope Iarna CONTINENTAL ContiWinterContact TS 830P 205/60 R16 96 H XL',
            'Anvelope Iarna CONTINENTAL ContiWinterContact TS 850 205/60 R15 91 H',
            'Anvelope Iarna CONTINENTAL ContiWinterContact TS 830P 235/45 R17 94 H'
        ];

        for ($i = 1; $i <= 30; $i++) {

            $type  = array_rand($types);
            $name    = array_rand(array_flip($names));
            $file = array_rand(array_flip($availableFiles));

            $product = new Product();
            $product->setName($name);
            $product->setType($type);
            $product->setDescription('CONTINENTAL ContiWinterContact TS 830P sunt anvelope de iarna sigure pentru autovehicule performante, caucicuuri iarna cu performante exceptionale de franare pe suprafete ude sau acoperite cu gheata. Numarul mare de blocuri rigide din centrul profilului si numeroasele striatii sinusoidale la 0 grade care determina formarea unui numar maxim de muchii aderente imbunatatesc semnificativ franarea pe drumurile ude si acoperite cu gheata sau zapada. Numarul mare de muchii aderente, blocuri si nervuri din umarul acestor anvelope CONTINENTAL ofera o tractiune excelenta si participa la eficientizarea franarii puternice pe suprafete acoperite cu apa sau zapada. Muchiile laterale ale profilului benzii de rulare confera o precizie buna a directiei in conditii extreme de iarna si o manevrabilitate sportiva pentru aceste caucicuuri Continental. Acvaplanarea prezinta un risc minim datorita distantei longitudinale scurte de scurgere a apei de-a lungul amprentei cu solul care favorizeaza evacuarea eficienta a apei. ContiWinterContact TS 830P sunt anvelope iarna cu un raspuns rapid al directiei si o manevrabilitate crescuta pe carosabil umed datorita caii de rulare divizate cu o duritate sporita. Distributia simetrica a blocurilor rigide a acestor cauciucuri de iarna, dar si presiunea distribuita uniforma a amprentei pe sol determina o uzura uniforma pentru a mari durata de viata a acestor caucicuuri iarna. Datorita performantelor de top ale franarii, aceste anvelope Continental interactioneaza direct cu ESC-ul (ESP-ul), raspunzand prompt la comenzile de franare ale acestuia. Striatiile sinusoidale sunt cele care ofera acest mare avantaj, ele fiind menite sa transfere fortele longitudinale si laterale pentru ca sofatul sa devena mult mai sigur. Datorita prezentei simbolurilor MS si a fulgului de nea in campul de informare a acestor anvelope, va bucurati de o calatorie sigura in conditii de iarna extrema. Compania de anvelope CONTINENTAL promoveaza inca de la infiintare in anul 1871, dezvoltarea industriei auto cu patente de referinta. Bucurandu-se de puterea sa inovatoare si de experienta acumulata an de an, producatorul CONTINENTAL este unul dintre primii cinci furnizori ai industriei auto din lume si ocupantul locului doi in Europa. Cu o gama diversificata de anvelope de buget si anvelope premium pentru toate anotimpurile, CONTINENTAL ramane un punct de reper in domeniu.');
            $product->setLink(Slug::generate($name));
            $product->setPrice(rand(280, 400));
            if ($product->save()) {
                $image = new Imagick($file);
                $image->resize(500, 500);
                $image->save(PRODUCT_IMAGE_DIR . $product->getId() . '.jpg');
                try {
                    copy($file, PRODUCT_IMAGE_DIR . 'original/' . $product->getId() . '-original.jpg');
                } catch (Exception $e) {
                    $this->flashSession->error($e->getMessage());
                }
            }
        }
    }

    /**
     * Method editAction
     */
    public function editAction($id)
    {
        if (!$object = Product::findFirstById($id)) {
            $this->flashSession->error('Product doesn\'t exist.');

            return $this->response->redirect($this->router->getControllerName());
        }
        $this->assets->addJs('../js/scripts.js');
        $this->view->form   = new ProductForm($object);
        $this->view->object = $object;
        $this->view->pick($this->router->getControllerName() . '/item');
    }

    /**
     * Add new Product
     */
    public function newAction()
    {
        $this->view->form = new ProductForm();
        $this->view->pick($this->router->getControllerName() . '/item');
        $this->assets->addJs('../js/scripts.js');
    }

    public function saveAction()
    {
        //  Is not $_POST
        if (!$this->request->isPost()) {
            $this->view->disable();

            return $this->response->redirect($this->router->getControllerName());
        }

        $id = $this->request->getPost('id', 'int', null);

        if (!empty($id)) {
            $object = Product::findFirstById($id);
        } else {
            $object = new Product();
        }

        $form = new ProductForm($object);
        $form->bind($_POST, $object);

        //  Form isn't valid
        if (!$form->isValid($this->request->getPost())) {
            foreach ($form->getMessages() as $message) {
                $this->flashSession->error($message->getMessage());
            }

            // Redirect to edit form if we have an ID in page, otherwise redirect to add a new item page
            return $this->response->redirect(
                $this->router->getControllerName() . (!is_null($id) ? '/edit/' . $id : '/new')
            );
        } else {
            if (!$object->save()) {
                foreach ($object->getMessages() as $message) {
                    $this->flashSession->error($message->getMessage());
                }

                return $this->dispatcher->forward(
                    ['controller' => $this->router->getControllerName(), 'action' => 'new']
                );
            } else {
                if ($this->request->hasFiles()) {
                    foreach ($this->request->getUploadedFiles() as $file) {
                        if ($this->imageCheck($file->getRealType())) {
                            $image = new Imagick($file->getTempName());
                            $image->resize(500, 500);
                            $image->save(PRODUCT_IMAGE_DIR . $object->getId() . '.jpg');
                            try {
                                $file->moveTo(PRODUCT_IMAGE_DIR . 'original/' . $object->getId() . '-original.jpg');
                            } catch (Exception $e) {
                                $this->flashSession->error($e->getMessage());
                            }
                        } else {
                            $this->flashSession->error('We don\'t accept that kind of file. Please upload an image.');
                            return $this->response->redirect($this->router->getControllerName());
                        }
                    }
                }
                $this->flashSession->success('Data was successfully saved');

                return $this->response->redirect($this->router->getControllerName());
            }
        }
    }

    /**
     * Attempt to determine the real file type of a file.
     *
     * @param  string $extension Extension (eg 'jpg')
     *
     * @return boolean
     */
    private function imageCheck($extension)
    {
        $allowedTypes = [
            'image/gif',
            'image/jpg',
            'image/png',
            'image/bmp',
            'image/jpeg'
        ];

        return in_array($extension, $allowedTypes);
    }

    public function deleteAction($id)
    {
        $object = Product::findFirstById((int)$id);

        if ($object && $object->delete()) {
            $this->flashSession->success('Object deleted successfully');
            @unlink(PRODUCT_IMAGE_DIR . $id . '.jpg');
            @unlink(PRODUCT_IMAGE_DIR . 'original' . DS . $id . '-original.jpg');
        } else {
            foreach ($object->getMessages() as $message) {
                $this->flashSession->error($message->getMessage());
            }
        }

        return $this->response->redirect($this->router->getControllerName());
    }
}