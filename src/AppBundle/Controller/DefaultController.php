<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Follow;
use AppBundle\Entity\Search;
use AppBundle\Entity\User;
use AppBundle\Form\SearchForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(SearchForm::class);

        $form->handleRequest($request);

        $searchResult = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $searchResult = $this->getDoctrine()->getRepository(User::class)->search($form->get('phrase')->getData());
        }

        $followed = [];
        if (null !== $this->getUser()) {
            $followed = $this->getDoctrine()->getRepository(Follow::class)->getFollowedByUser($this->getUser()->getId());
        }
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'logged_user' => $this->getUser(),
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'result' => array_map(
                function (User $group) {
                    $group->setFollower(
                        $this->getDoctrine()->getRepository(Follow::class)->getFollowersByUser($group->getId())
                    );
                    return $group;
                }, $searchResult
            ),
            'followed' => array_flip(array_map(
                function (Follow $follow) {
                    return $follow->getGroup()->getId();
                },
                $followed
            ))
        ]);
    }

    /**
     * @Route("/follow", name="follow_group")
     */
    public function followAction(Request $request)
    {
        $artistId = $_POST['artist_id'];
        $userId = $this->getUser()->getId();

        $follow = new Follow();
        $follow->setFan($this->getDoctrine()->getEntityManager()->getReference(User::class, $userId));
        $follow->setGroup($this->getDoctrine()->getEntityManager()->getReference(User::class, $artistId));
        $this->getDoctrine()->getEntityManager()->persist($follow);
        $this->getDoctrine()->getEntityManager()->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/assign_role/{id}/{role}", name="assign_role")
     */
    public function assignRoleAction(Request $request, User $user, $role)
    {
        if (!empty($role)) {
            $user->setRoles([$role]);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
        }
        dump($user);

        return $this->render('base.html.twig');
    }
}
