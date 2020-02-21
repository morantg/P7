<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use OpenApi\Annotations as OA;

class ClientController extends AbstractController
{
    
    /**
     * @Route("/api/clients/{id}", name="app_clients_show", methods={"GET"})
     * @OA\Get(
     *     path="/api/clients/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",     
     *         description="id du client",
     *         required=true,
     *         @OA\Schema(type="integer")  
     *     ),  
     *     @OA\Response(
     *         response="200",
     *         description="Le client",
     *         @OA\JsonContent(ref="#/components/schemas/Client")  
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="La ressource n'existe pas",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Resource not found")
     *         )  
     *     )      
     * )
     */
    public function showAction(Client $client, ClientRepository $clientRepository, Request $request, UserInterface $user)
    {
        
        if($user != $client->getUser()){
            return $this->json([
                'status' => 401,
                'message' => "Acces Denied"
            ], 401);
        }
        return $this->json($client, 200, [], ['groups' => 'client:read']);
    }
    
    /**
     * @Route("/api/clients", name="app_clients_list", methods={"GET"})
     * @OA\Get(
     *     path="/api/clients",
     *     @OA\Response(
     *         response="200",
     *         description="Les clients",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Client"))  
     *     ) 
     * )
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

    /**
     * @Route("/api/clients", name="app_clients_create", methods={"POST"})
     * @OA\Post(
     *     path="/api/clients",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Client")         
     *     ), 
     *     @OA\Response(
     *         response="201",
     *         description="Un client",
     *         @OA\JsonContent(ref="#/components/schemas/Client")  
     *     ) 
     * )
     */
    public function createAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, UserInterface $user)
    {
        
        $jsonRecu = $request->getContent();

        try {
        $client = $serializer->deserialize($jsonRecu, Client::class, 'json');
        $client->setDateAjoutAt(new \DateTime());
        $client->setUser($user);  
        
        $errors = $validator->validate($client);
        
        if(count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em->persist($client);
        $em->flush();
        
        return $this->json($client, 201, [], ['groups' => 'client:read']);
        }catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
        
    }

    /**
     * @Route("/api/clients/{id}", name="app_clients_update", methods={"PUT"})
     * @OA\Put(
     *     path="/api/clients/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",     
     *         description="id du client",
     *         required=true,
     *         @OA\Schema(type="integer")  
     *     ),   
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Client")
     *     ), 
     *     @OA\Response(
     *         response="200",
     *         description="Un client",
     *         @OA\JsonContent(ref="#/components/schemas/Client")  
     *     ) 
     * )
     */
    public function updateAction(Client $client,ClientRepository $clientRepository, Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, UserInterface $user)
    {
        
        if($user != $client->getUser()){
            return $this->json([
                'status' => 401,
                'message' => "Acces Denied"
            ], 401);
        }
        
        $jsonRecu = $request->getContent();

        try{
        $clientValidate = $serializer->deserialize($jsonRecu, Client::class, 'json');
        
        $errors = $validator->validate($clientValidate);
        
        if(count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $form = $this->createForm(ClientType::class, $client);

        $data = json_decode($request->getContent(), true);
        $data['dateAjoutAt'] = $client->getDateAjoutAt();
        $data['user'] = $client->getUser();
        
        $form->submit($data);
        $client->setDateModifAt(new \DateTime());
        
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

        $em->persist($client);
        $em->flush();

        return $this->json([
            'status' => 200,
            'message' => "le client a bien été mis à jour"
        ], 200);
        
    }

     /**
     * @Route("/api/clients/{id}", name="app_clients_delete", methods={"DELETE"})
     * @OA\Delete(
     *     path="/api/clients/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",     
     *         description="id du client",
     *         required=true,
     *         @OA\Schema(type="integer")  
     *     ),   
     *     @OA\Response(
     *         response="204",
     *         description="Un client",
     *         @OA\JsonContent(ref="#/components/schemas/Client")  
     *     ) 
     * )
     */
    public function deleteAction(Client $client, Request $request, EntityManagerInterface $em, UserInterface $user)
    {
        
        if($user != $client->getUser()){
            return $this->json([
                'status' => 401,
                'message' => "Acces Denied"
            ], 401);
        }
        
        $em->remove($client);
        $em->flush();
        
        return $this->json(null, 204);
    }

}
