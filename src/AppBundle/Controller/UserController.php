<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/registration", name="user_register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $editForm = $this->createForm('AppBundle\Form\RegistrationType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('homepage');
            } catch (\Exception $e) {
                $editForm->addError(new FormError('Username o email duplicati'));
            }
        }

        return $this->render('user/register.html.twig', array(
            'form' => $editForm->createView(),
            'title' => 'Registrazione'
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/registration/step1/{id}", name="user_register_step1")
     * @Method({"GET", "POST"})
     */
    public function registrationStep1(Request $request, User $user)
    {
        $editForm = $this->createForm('AppBundle\Form\RegistrationStep1Type', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('user_register_step2', array('id' => $user->getId()));
            }catch (\Exception $e) {
                $editForm->addError(new FormError('Il nome che hai scelto è già presente sul nostro sito'));
            }
        }

        return $this->render('user/register.html.twig', array(
            'form' => $editForm->createView(),
            'title' => 'Un altro piccolo sforzo',
            'nextRoute' => $this->generateUrl('user_register_step2', array('id' => $user->getId()))
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/registration/step2/{id}", name="user_register_step2")
     * @Method({"GET", "POST"})
     */
    public function registrationStep2(Request $request, User $user)
    {
        $editForm = $this->createForm('AppBundle\Form\RegistrationStep2Type', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('user_show', array('id' => $user->getId()));
            } catch(\Exception $e) {
                $editForm->addError(new FormError('Il nome che hai scelto è già presente sul nostro sito'));
            }
        }

        return $this->render('user/register.html.twig', array(
            'form' => $editForm->createView(),
            'title' => 'Questo passaggio non è obbligatorio',
            'nextRoute' => $this->generateUrl('homepage')
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush($user);
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
