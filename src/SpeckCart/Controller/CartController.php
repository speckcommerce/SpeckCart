<?php

namespace SpeckCart\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SpeckCart\Entity\CartItem;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;

class CartController extends AbstractActionController
{
    public function indexAction()
    {
        $cs = $this->getCartService();
        $cart = $cs->getSessionCart();

        return new ViewModel(array(
            'cart' => $cart
        ));
    }

    public function emptyCartAction()
    {
        $prg = $this->prg('cart/empty-cart');

        // If a response is returned we want to reload before continuing...
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $cs = $this->getCartService();
            $cs->emptyCart();
        }

        return $this->redirect()->toRoute('cart');
    }

    public function updateQuantitiesAction()
    {
        $prg = $this->prg('cart/update-quantities');

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $this->getCartService()->updateQuantities($prg['quantities']);
        }

        return $this->redirect()->toRoute('cart');
    }

    public function getCartService()
    {
        if (!isset($this->cartService)) {
            $this->cartService = $this->getServiceLocator()->get('SpeckCart\Service\CartService');
        }

        return $this->cartService;
    }

    public function setCartService($service)
    {
        $this->cartService = $service;
        return $this;
    }
}
