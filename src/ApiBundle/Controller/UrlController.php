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

        $url = new Url();
        $url->setTinyUrl('Shmee');
        $url->setTargetUrl('Banana');
        $url->setTimeStamp(new \DateTime("now"));

        $jsonContent = $serializer->serialize($url, 'json');
        return new Response($jsonContent);
    }

    public function createAction(Request $request)
    {
        return new JsonResponse(array('name' => 'create action'));
    }
}
