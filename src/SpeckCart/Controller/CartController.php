<?php

namespace SpeckCart\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    SpeckCart\Entity\CartItem,
    Zend\View\Model\ViewModel;

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
