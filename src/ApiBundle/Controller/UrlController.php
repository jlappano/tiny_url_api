<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\Url;

class UrlController extends Controller
{
    public function listAction(Request $request)
    {
        $serializer = $this->get('serializer');
        $urlRepository = $this->getDoctrine()->getRepository('ApiBundle:Url');
        $allUrls = $urlRepository->findAll();

        $jsonContent = $serializer->serialize($allUrls, 'json', array('groups' => array('listGroup')));
        $response = new Response();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function createAction(Request $request)
    {
        return new JsonResponse(array('name' => 'create action'));
    }
}
