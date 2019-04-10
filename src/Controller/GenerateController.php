<?php

namespace App\Controller;

use App\Entity\ApiEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GenerateController extends AbstractController
{
    /**
     * @Route("/api/generate", name="generate")
     */
    public function index()
    {
       $random_value = mt_rand();
       $random_value_key = md5($random_value);

       $db = new ApiEntity();

       $db->setValue($random_value);
       $db->setValueKey($random_value_key);

       $this->getDoctrine()->getManager()->persist($db);
       $this->getDoctrine()->getManager()->flush();

       $end_arr = ['value' => $random_value, 'key' => $random_value_key];

       return new JsonResponse($end_arr);
    }
}
