<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UrlController extends Controller
{
    public function listAction(Request $request)
    {
        return new JsonResponse(array('name' => 'list action'));
    }

    public function createAction(Request $request)
    {
        return new JsonResponse(array('name' => 'create action'));
    }
}
