<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PhoneController extends AbstractController
{
    
    /**
     * @Route("/api/phones/{id}", name="app_phones_show", methods={"GET"})
     */
    public function showAction(Phone $phone, PhoneRepository $phoneRepository, Request $request)
    {
        
        $phone = $phoneRepository->find($phone->getId());

        return $this->json($phone, 200, [], ['groups' => 'phone:read']);
    }
    
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

    /**
     * @Route("/api/phones", name="app_phones_create", methods={"POST"})
     */
    public function createAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['error' => 'Role ADMIN nécessaire'], 401);
        }
        
        $jsonRecu = $request->getContent();

        $phone = $serializer->deserialize($jsonRecu, Phone::class, 'json');

        $em->persist($phone);
        $em->flush();
        
        return $this->json($phone, 201, [], ['groups' => 'phone:read']);
        
    }

}




