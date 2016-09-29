<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
        $jsonContent = $request->getContent();
        $content = json_decode($jsonContent, true);


        if (!is_null($content) && array_key_exists('url', $content)) {

            $urlService = $this->get('url_service');
            $givenUrl = $content['url'];

            $newUrl = new Url();
            $newUrl->setTimeStamp(new \DateTime('now'));
            $hash = $newUrl->generateUniqueHash();
            $tinyUrl = $urlService->encode($hash);
            $newUrl->setHash($hash);
            $newUrl->setTinyUrl($tinyUrl);
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($newUrl);
            // $em->flush();

            $responseContent = json_encode(array('tiny url' => $tinyUrl));
            $response = new Response();
            $response->setContent($responseContent);
            $response->headers->set('Content-Type', 'application/json'); 
            return $response;
        }

        $response = new Response();
        $responseContent = json_encode(array('malformed request' => 'must request url'));
        $response->setContent($jsonContent);
        $response->setStatusCode(400);
        $response->headers->set('Content-Type', 'application/json'); 
        return $response;
    }
}
