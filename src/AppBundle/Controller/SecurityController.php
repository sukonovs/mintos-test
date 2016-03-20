<?php namespace AppBundle\Controller;

/**
 * Security controller
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package AppBundle\Controller
 */

use Symfony\Component\HttpFoundation\Request;
use \FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    /**
     * Redirect if already logged in
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            
            return $this->redirectToRoute('loans_index');
        }

        return parent::loginAction($request);
    }
}