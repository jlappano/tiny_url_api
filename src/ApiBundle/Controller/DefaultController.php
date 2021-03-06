<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ApiBundle\Entity\Url;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
    * Redirects user to appropriate target url 
    * Must give existing tiny url
    */
    public function redirectAction(Request $request, $tinyUrl)
    {

        $em = $this->getDoctrine()->getManager();
        $urlRepository = $this->getDoctrine()->getRepository('ApiBundle:Url');
        $url = $urlRepository->findOneByTinyUrl($tinyUrl);
        if(empty($url)) throw new NotFoundHttpException('Url target not found');

        $userAgent = $request->headers->get('User-Agent');
        $userAgentService = $this->get('user_agent_service');
        $redirectUrl = $userAgentService->getRedirectUrl($url, $userAgent);
        $response = new RedirectResponse($redirectUrl);
        return $response;
    }
}
