<?php
/**
 * Created by PhpStorm.
 * User: Ixia
 * Date: 17/05/18
 * Time: 23:35
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Page;
use AppBundle\Form\PageCreateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class PageCreate extends Controller
{

    /**
     * @Route("/page/create", name="page_create")
     */
    public function createPage(Request $request)
    {
        $page = new Page();
        $pageCreateType = $this->createForm(PageCreateType::class, $page, [
            'user' => $this->getUser()
        ]);

        $pageCreateType->handleRequest($request);

        if ($pageCreateType->isSubmitted()) {

//            $page->addAdmin($this->getUser());
            $page->setFounder($this->getUser());

            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($page);
dump($page);
                $em->flush();
//                return $this->redirectToRoute('homepage');
            }catch (\Exception $e) {
dump($e);
            }
        }

        return $this->render('page/create.html.twig', [
            'form' => $pageCreateType->createView()
        ]);
    }

}