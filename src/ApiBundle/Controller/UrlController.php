<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ApiBundle\Entity\Url;
use ApiBundle\Entity\Redirect;

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

    public function updateAction(Request $request)
    {
        $jsonContent = $request->getContent();
        $content = json_decode($jsonContent, true);

        if (!is_null($content) && array_key_exists('tiny_url', $content)) {

            $tinyUrl = $content['tiny_url'];
            $em = $this->getDoctrine()->getManager();
            $urlRepository = $this->getDoctrine()->getRepository('ApiBundle:Url');
            $url = $urlRepository->findOneByTinyUrl($tinyUrl);

            if(!empty($url)){
                if(array_key_exists('tablet_target', $content)) {
                    $url->setTargetTabletUrl($content['tablet_target']);
                }
                if(array_key_exists('mobile_target', $content)) {
                    $url->setTargetMobileUrl($content['mobile_target']);
                }
                if(array_key_exists('desktop_target', $content)) {
                    $url->setTargetDesktopUrl($content['desktop_target']);
                }
            }

            $em->persist($url);
            $em->flush();

            $responseContent = json_encode(array('tiny url' => $tinyUrl));
            $response = new Response();
            $response->setContent($responseContent);
            $response->headers->set('Content-Type', 'application/json'); 
            return $response;
        }

        $response = new Response();
        $responseContent = json_encode(array('malformed request' => 'missing parameters'));
        $response->setContent($jsonContent);
        $response->setStatusCode(400);
        $response->headers->set('Content-Type', 'application/json'); 
        return $response;

    }

    public function redirectAction(Request $request)
    {
        $jsonContent = $request->getContent();
        $content = json_decode($jsonContent, true);

        if (!is_null($content) && array_key_exists('tiny_url', $content)) {

            $tinyUrl = $content['tiny_url'];
            $em = $this->getDoctrine()->getManager();
            $urlRepository = $this->getDoctrine()->getRepository('ApiBundle:Url');
            $url = $urlRepository->findOneByTinyUrl($tinyUrl);

            $userAgentService = $this->get('user_agent_service');
            $userAgent = $request->headers->get('User-Agent');
            $redirectUrl = $this->getRedirectUrl();

            $response = new RedirectResponse($redirectUrl);
            $response->headers->set('Content-Type', 'application/json'); 
            return $response;
        }

        $response = new Response();
        $responseContent = json_encode(array('malformed request' => 'missing parameters'));
        $response->setContent($jsonContent);
        $response->setStatusCode(400);
        $response->headers->set('Content-Type', 'application/json'); 
        return $response;

    }

    public function createAction(Request $request)
    {
        $jsonContent = $request->getContent();
        $content = json_decode($jsonContent, true);

        if (!is_null($content) && array_key_exists('url', $content)) {

            $urlService = $this->get('url_service');
            $newUrl = new Url();
            $hash = $newUrl->generateUniqueHash();
            $tinyUrl = $urlService->encode($hash);
            $givenUrl = $content['url'];

            $newUrl->setTimeStamp(new \DateTime('now'));
            $newUrl->setHash($hash);
            $newUrl->setTinyUrl($tinyUrl);
            $newUrl->setTargetDesktopUrl($givenUrl);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newUrl);
            $em->flush();

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

    private function getRedirectUrl($url, $userAgent)
    {
        $redirectUrl = '';
        $em = $this->getDoctrine()->getManager();

        if($userAgentService->isMobile($userAgent) && !is_null($url->getTargetMobileUrl())){
            $redirectUrl = $url->getTargetMobileUrl();

            if(!in_null($url->getRedirect())){
                $redirect = $url->getRedirect();
            } else {
                $redirect = new Redirect();
                $url->setRedirect($redirect);
            }

            $redirect->incrementMobileRedirects();
            $em->persist($redirect);

        } elseif ($userAgentService->isTablet($userAgent) && !is_null($url->getTargetTabletUrl())) {
            $redirectUrl = $url->getTargetTabletUrl();

            if(!in_null($url->getRedirect())){
                $redirect = $url->getRedirect();
            } else {
                $redirect = new Redirect();
                $url->setRedirect($redirect);
            }
            
            $redirect->incrementTabletRedirects();
            $em->persist($redirect);

        } else {
            $redirectUrl = $url->getTargetDesktopUrl();

            if(!in_null($url->getRedirect())){
                $redirect = $url->getRedirect();
            } else {
                $redirect = new Redirect();
                $url->setRedirect($redirect);
            }
            
            $redirect->incrementDesktopRedirects();
            $em->persist($redirect);
        }
        $em->flush();
        return $redirectUrl;
    }
}
