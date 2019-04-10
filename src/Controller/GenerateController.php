<?php

namespace App\Controller;

use App\Entity\ApiEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GenerateController extends AbstractController
{
    /**
     * @Route("/api/generate", name="generate")
     */
    public function index(Request $request)
    {
        switch ($request->query->get('type')) {
            case 'string':

                $random_value = md5(time());
                $random_value = preg_replace('/[0-9]+/', '', $random_value);
                $random_value_key = md5($random_value);
                break;

            case 'num':

                $random_value = mt_rand();
                $random_value_key = md5($random_value);
                break;

            case 'numstr':

                $random_value = md5(time());
                $random_value_key = md5($random_value);
                break;

            case 'guid':

                $random_value = \com_create_guid();
                $random_value_key = md5($random_value);
                break;

            default:
                return new JsonResponse('Smth wrong');

        }

        $db = new ApiEntity();

        $db->setValue($random_value);
        $db->setValueKey($random_value_key);

        $this->getDoctrine()->getManager()->persist($db);
        $this->getDoctrine()->getManager()->flush();

        $end_arr = ['value' => $random_value, 'key' => $random_value_key];

        return new JsonResponse($end_arr);
    }
}
