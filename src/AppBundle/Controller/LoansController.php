<?php

namespace AppBundle\Controller;

use Exception;
use AppBundle\Entity\Investment;
use AppBundle\Form\Type\InvestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoansController extends Controller
{
    /**
     * Show all loans
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $loans = $this->getDoctrine()->getManager()->getRepository('AppBundle:Loan')->findBy([], ['id' => 'ASC']);


        array_map(function ($loan) {
            $loan->url = $this->generateUrl('loans_edit', ['id' => $loan->getId()]);

            return $loan;
        }, $loans);

        $pagination = $this->get('knp_paginator')->paginate($loans, $request->query->getInt('page', 1));

        return $this->render('loans/index.html.twig',
            compact('user', 'pagination')
        );
    }

    /**
     * Edit loan
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $loan = $this->getDoctrine()->getManager()->getRepository('AppBundle:Loan')->find($id);

        if (!$user->canInvest() || !$loan->canBeInvested()) {

            return $this->redirectToRoute('loans_index');
        }

        $form = $this->createForm(InvestType::class, null, [
            'action' => $this->generateUrl('loans_update', ['id' => $loan->getId()]),
            'method' => 'PUT',
            'available_for_investment' => $loan->getAvailableForInvestments()
        ])->createView();

        return $this->render('loans/edit.html.twig',
            compact('user', 'loan', 'form')
        );
    }


    /**
     * Update loan
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $loan = $manager->getRepository('AppBundle:Loan')->find($id);

        if (!$user->canInvest() || !$loan->canBeInvested()) {

            return $this->redirectToRoute('loans_index');
        }

        $form = $this->createForm(InvestType::class, null, [
            'action' => $this->generateUrl('loans_update', ['id' => $loan->getId()]),
            'method' => 'PUT',
            'available_for_investment' => $loan->getAvailableForInvestments()
        ]);

        $form->handleRequest($request);

        if (!$form->isValid()) {

            $form = $form->createView();

            return $this->render('loans/edit.html.twig',
                compact('user', 'loan', 'form')
            );
        }

        $manager->getConnection()->beginTransaction();

        try {
            $investedAmount = $form->get('invest')->getData();
            $userAvailableInvestments = $user->getAvailableForInvestments() - $investedAmount;
            $loanAvailableForInvestments = $loan->getAvailableForInvestments() - $investedAmount;

            if ($userAvailableInvestments < 0 || $loanAvailableForInvestments < 0) {

                throw new Exception('Business logic error');
            }

            $user->setAvailableForInvestments($userAvailableInvestments);
            $loan->setAvailableForInvestments($loanAvailableForInvestments);

            $investment = new Investment;
            $investment->setUser($user);
            $investment->setLoan($loan);
            $investment->setAmount($investedAmount);

            $user->addInvestment($investment);

            $manager->persist($user);
            $manager->persist($loan);
            $manager->flush();

            $manager->getConnection()->commit();
        } catch (Exception $e) {
            $manager->getConnection()->rollback();
            throw $e;
        }

        return $this->redirect($this->generateUrl('loans_index'));
    }
}
