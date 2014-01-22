<?php

namespace PaymentSuite\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

use PaymentSuite\FrontBundle\Entity\Order;
use PaymentSuite\FrontBundle\Entity\Cart;


/**
 * @Route("sandbox/")
 */
class PaymentController extends Controller
{

    /**
     * Method for listing all possible payment methods
     * 
     * @Route("", name="sandbox")
     * @Template()
     */
    public function checkoutAction(Request $request)
    {
        $session = $this->get('session');
        $entityManager = $this
            ->getDoctrine()
            ->getManager();

        if ($session->get('cart_id')) {

            $cart = $entityManager
                ->getRepository('PaymentSuiteFrontBundle:Cart')
                ->find($session->get('cart_id'));

        } else {

            $cart = new Cart();
            $cart->setPrice(50);
            $entityManager->persist($cart);
            $entityManager->flush();

            $session->set('cart_id', $cart->getId());
        }

        return array(
            'cart'  =>  $cart,
        );
    }


    /**
     * Return url with success status
     *
     * @Route("/success/{order_id}", name="payment_success")
     * @Template()
     * 
     * @ParamConverter("order", class="PaymentSuiteFrontBundle:Order", options= {
     *      "id"= "order_id"
     * })
     */
    public function successAction(Request $request, Order $order)
    {

    }


    /**
     * Return url with failed status
     *
     * @Route("/fail/{cart_id}", name="payment_failed")
     * @Template()
     * 
     * @ParamConverter("cart", class="PaymentSuiteFrontBundle:Cart", options= {
     *      "id"= "cart_id"
     * })
     */
    public function failedAction(Request $request, Cart $cart)
    {

    }
}
