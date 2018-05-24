<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Events;
use AppBundle\Entity\Slot;
use AppBundle\Entity\Stage;
use AppBundle\Entity\UserEvent;
use AppBundle\Form\SlotType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Event controller.
 *
 * @Route("events")
 */
class EventsController extends Controller
{
    /**
     * Lists all event entities.
     *
     * @Route("/", name="events_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Events')->findAll();

        return $this->render('events/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new event entity.
     *
     * @Route("/new", name="events_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $event = new Events();
        $form = $this->createForm('AppBundle\Form\EventsType', $event, [
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $event->setUser($this->getUser());
            $em->persist($event);
            $em->flush();

            if (in_array(['ROLE_GROUP', 'ROLE_STANDER'], $this->getUser()->getRoles())) {
                return $this->redirectToRoute('events_index');
            } else {
                return $this->redirectToRoute('events_stage_new', array('id' => $event->getId()));
            }
        }

        return $this->render('events/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new event entity.
     *
     * @Route("/new/{id}/stage", name="events_stage_new")
     * @Method({"GET", "POST"})
     */
    public function newStageAction(Request $request)
    {
        $stage = new Stage();
        $form = $this->createForm('AppBundle\Form\StageType', $stage);
        $form->handleRequest($request);
        /**
         * @var $em EntityManagerInterface
         */
        $em = $this->getDoctrine()->getManager();
        $event = $em->getReference(Events::class, $request->get('id'));

        if ($form->isSubmitted() && $form->isValid()) {
            $stage->setEvent($event);
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('events_stage_new', array(
                'id' => $event->getId(),
                'event' => $event
            ));
        }

        return $this->render('events/new.stage.html.twig', array(
            'stage' => $stage,
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new slot entity.
     *
     * @Route("/new/{id}/slot", name="events_slot_new")
     * @Method({"GET", "POST"})
     */
    public function newSlotAction(Request $request)
    {
        $slot = new Slot();
        $form = $this->createForm(SlotType::class, $slot);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($slot);
            $em->flush();

            return $this->redirectToRoute('events_slot_new', array(
                'id' => $request->get('id'),
            ));
        }

        return $this->render('events/new.slot.html.twig', array(
            'slot' => $slot,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{id}", name="events_show")
     * @Method("GET")
     */
    public function showAction(Events $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        $bookable = true;
        $userEvent = $this->getDoctrine()->getEntityManager()->getRepository(UserEvent::class)->getByUserAndEvent(
            $this->getUser(), $event
        );
        if (!empty($userEvent)) {
            $bookable = false;
        }

        return $this->render('events/show.html.twig', array(
            'daysInMonth' => cal_days_in_month(CAL_GREGORIAN, $event->getDateOpen()->format('m'), $event->getDateOpen()->format('Y')),
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
            'bookable' => $bookable
        ));
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="events_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Events $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('AppBundle\Form\EventsType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_edit', array('id' => $event->getId()));
        }

        return $this->render('events/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="events_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Events $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush($event);
        }

        return $this->redirectToRoute('events_index');
    }


    /**
     * Deletes a event entity.
     *
     * @Route("/{id}/book", name="event_book")
     */
    public function bookAction(Request $request, Events $event)
    {
        $loggedUser = $this->getUser();

        $eventUser = new UserEvent();
        $eventUser->setUser($loggedUser);
        $eventUser->setEvent($event);

        $this->getDoctrine()->getEntityManager()->persist($eventUser);
        $this->getDoctrine()->getEntityManager()->flush();

        return $this->redirectToRoute('events_show', ['id' => $event->getId()]);
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Events $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Events $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('events_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
