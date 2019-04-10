<?php

namespace App\Controller;

use App\Entity\ApiEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RetrieveController extends AbstractController
{
    /**
     * @Route("/api/retrieve", name="retrieve")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(ApiEntity::class);

        $key = $request->query->get('key');

        $db_value = $em->findByValue($key);

        $db_value = array_shift($db_value); //тк возвращается массив массивов

        $db_value = array_slice($db_value, 1); //тк возвращется еще и id

        return new JsonResponse($db_value);
    }
}
