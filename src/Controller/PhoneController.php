<?php

namespace App\Controller;

use App\Repository\PhoneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PhoneController extends AbstractController
{
    /**
     * @Route("/api/phones", name="app_phones_list", methods={"GET"})
     */
    public function listAction(PhoneRepository $phoneRepository, Request $request)
    {
        $phones = $phoneRepository->findAll();

        return $this->json($phones, 200);
    }
}




