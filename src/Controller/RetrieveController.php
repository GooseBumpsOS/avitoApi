<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RetrieveController extends AbstractController
{
    /**
     * @Route("/api/retrieve", name="retrieve")
     */
    public function index()
    {
        return $this->render('retrieve/index.html.twig', [
            'controller_name' => 'RetrieveController',
        ]);
    }
}
