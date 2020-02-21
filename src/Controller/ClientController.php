<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
     /**
     * @Route("/api/clients", name="app_clients_list", methods={"GET"})
     */
    public function listAction(ClientRepository $clientRepository, Request $request, UserInterface $user)
    {
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $clients = $clientRepository->findAll();
        }else{
            $clients = $clientRepository->findBy([
                'user' => $user
            ]);
        }
        
        return $this->json($clients, 200, [], ['groups' => 'client:read']);
    }
}
