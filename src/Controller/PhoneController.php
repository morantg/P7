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
     * @Route("/api/phones/{page<\d+>?1}", name="app_phones_list", methods={"GET"})
     */
    public function listAction(PhoneRepository $phoneRepository, Request $request)
    {
        
        $page = $request->query->get('page');
        if(is_null($page) || $page < 1){
            $page = 1;
        }
        $limit = 2;
        
        $phones = $phoneRepository->findAllPhones($page, $limit);

        return $this->json($phones, 200, [], ['groups' => 'phone:read']);
    }
}




