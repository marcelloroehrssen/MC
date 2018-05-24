<?php
/**
 * Created by PhpStorm.
 * User: Ixia
 * Date: 13/03/18
 * Time: 23:18
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GroupController
 * @package AppBundle\Controller
 *
 * @Route("group")
 */
class GroupController extends Controller
{

    /**
     * @Route("/{groupName}", name="group_detail")
     */
    public function showAction(Request $request, $groupName)
    {
        $loggedUser = $this->getUser();
        /**
         * @var $group User
         */
        $group = $this->getDoctrine()->getRepository(User::class)->getGroupByUrl($groupName);

        $isMine = false;
        if ( !empty($loggedUser) && $group->getId() == $loggedUser->getId()) {
            $isMine = true;
        }
        $news = $group->getNews();
        $socials = $group->getSocials();
        $extended = $group->getExtendedInfo();

        return $this->render('group/detail.html.twig', [
            'group' => $group,
            'isMine' => $isMine
        ]);
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{groupName}/calendar", name="group_calendar")
     */
    public function getCalendarAction(Request $request, $groupName)
    {
        /**
         * @var $group User
         */
        $group = $this->getDoctrine()->getRepository(User::class)->getGroupByUrl($groupName);

        $events = $group->getEvents();
        $calendar = [];

        foreach ($events as $event) {
            $dateOpen = $event->getDateOpen();
            $calendar[$dateOpen->format("j")][] = $event;
            for ($i = 1; $i < $event->getDuration(); $i++) {
                $durationDate = $dateOpen->add(new \DateInterval("P1D"));
                $calendar[$durationDate->format("j")][] = $event;
            }
        }

        ksort($calendar);

        $firstDayOfTheMonth = null;
        $monthName = null;
        $dayInMonth = null;
        $thereIsSomeEvents = false;
        if (!empty($events[0])) {
            $firstDayOfTheMonth = $events[0]->getDateOpen()->format('Y-m-') . "01";
            $monthName = $events[0]->getDateOpen()->format('F');
            $dayInMonth = cal_days_in_month(CAL_GREGORIAN, $event->getDateOpen()->format('m'), $event->getDateOpen()->format('Y'));
            $thereIsSomeEvents = true;
        }

        return $this->render('group/calendar.html.twig', [
            'thereIsSomeEvents' => $thereIsSomeEvents,
            'group' => $group,
            'groupName' => $group->getGroupNameLong(),
            'firstDayOfTheMonth' => $firstDayOfTheMonth,
            'monthName' => $monthName,
            'daysInMonth' => $dayInMonth,
            'calendar' => $calendar,
        ]);
    }
}