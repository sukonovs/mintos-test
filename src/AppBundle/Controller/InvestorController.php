<?php namespace AppBundle\Controller;

/**
 * Investor controller
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package AppBundle\Controller
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvestorController extends Controller
{
    /**
     * Show investor
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $investments = $user->getInvestments();

        return $this->render('investors/show.html.twig', compact('user', 'investments'));
    }
}