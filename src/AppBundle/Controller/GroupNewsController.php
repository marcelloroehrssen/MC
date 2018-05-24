<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GroupNews;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Groupnews controller.
 *
 * @Route("groupnews")
 */
class GroupNewsController extends Controller
{
    /**
     * Lists all groupNews entities.
     *
     * @Route("/", name="groupnews_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        if (!in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {
            $group = $em->getRepository(User::class)->find($this->getUser()->getId());
            $groupNews = $em->getRepository('AppBundle:GroupNews')->findByGroup($group);
        } else {
            $groupNews = $em->getRepository('AppBundle:GroupNews')->findAll();
        }

        return $this->render('groupnews/index.html.twig', array(
            'groupNews' => $groupNews,
        ));
    }

    /**
     * Creates a new groupNews entity.
     *
     * @Route("/new", name="groupnews_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, \Swift_Mailer $mailer = null)
    {
        $groupNews = new GroupNews();
        $form = $this->createForm('AppBundle\Form\GroupNewsType', $groupNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $group = $em->getRepository(User::class)->find($this->getUser()->getId());

            $em->getRepository(GroupNews::class)->deleteAll($group);
            $groupNews->setGroup($group);
            $em->persist($groupNews);
            $em->flush($groupNews);

//            $message = (new \Swift_Message('Hello Email'))
//                ->setFrom('send@example.com')
//                ->setTo('marcello.roehrssen@gmail.com')
//                ->setBody(
//                    $this->renderView(
//                    /**
//                     * @toDo inserire il template della mail
//                     */
//                        'emails/news.html.twig',
//                        array('name' => 'Pamela')
//                    ),
//                    'text/html'
//                );
//            $mailer->send($message);

            return $this->redirectToRoute('groupnews_show', array('id' => $groupNews->getId()));
        }

        return $this->render('groupnews/new.html.twig', array(
            'groupNews' => $groupNews,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a groupNews entity.
     *
     * @Route("/{id}", name="groupnews_show")
     * @Method("GET")
     */
    public function showAction(GroupNews $groupNews)
    {
        $deleteForm = $this->createDeleteForm($groupNews);

        return $this->render('groupnews/show.html.twig', array(
            'groupNews' => $groupNews,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing groupNews entity.
     *
     * @Route("/{id}/edit", name="groupnews_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, GroupNews $groupNews)
    {
        $deleteForm = $this->createDeleteForm($groupNews);
        $editForm = $this->createForm('AppBundle\Form\GroupNewsType', $groupNews);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('groupnews_edit', array('id' => $groupNews->getId()));
        }

        return $this->render('groupnews/edit.html.twig', array(
            'groupNews' => $groupNews,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a groupNews entity.
     *
     * @Route("/{id}", name="groupnews_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GroupNews $groupNews)
    {
        $form = $this->createDeleteForm($groupNews);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($groupNews);
            $em->flush($groupNews);
        }

        return $this->redirectToRoute('groupnews_index');
    }

    /**
     * Creates a form to delete a groupNews entity.
     *
     * @param GroupNews $groupNews The groupNews entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GroupNews $groupNews)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groupnews_delete', array('id' => $groupNews->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
