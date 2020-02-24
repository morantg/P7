<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Form\PhoneType;
use OpenApi\Annotations\Post;
use OpenApi\Annotations as OA;
use App\Repository\PhoneRepository;
use OpenApi\Annotations\RequestBody;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class PhoneController extends AbstractController
{
    
    /**
     * @Route("/api/phones/{id}", name="app_phones_show", methods={"GET"})
     * @OA\Get(
     *     path="/api/phones/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",     
     *         description="id du téléphone",
     *         required=true,
     *         @OA\Schema(type="integer")  
     *     ),  
     *     @OA\Response(
     *         response="200",
     *         description="Le téléphone",
     *         @OA\JsonContent(ref="#/components/schemas/Phone")  
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
    public function showAction(Phone $phone)
    {
        
        return $this->json($phone, 200, [], ['groups' => 'phone:read']);
    }
    
    /**
     * @Route("/api/phones/{page<\d+>?1}", name="app_phones_list", methods={"GET"})
     * @OA\Get(
     *     path="/api/phones",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="La page a consulter",
     *         required=false,
     *         @OA\Schema(type="integer")     
     *     ), 
     *     @OA\Response(
     *         response="200",
     *         description="Nos téléphones",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Phone"))  
     *     ) 
     * )
     */
    public function listAction(PhoneRepository $phoneRepository, Request $request)
    {
        
        $page = $request->query->get('page');
        if($page === null || $page < 1){
            $page = 1;
        }
        $limit = 10;
        
        $phones = $phoneRepository->findAllPhones($page, $limit);

        return $this->json($phones, 200, [], ['groups' => 'phone:read']);
    }

    /**
     * @Route("/api/phones", name="app_phones_create", methods={"POST"})
     * @OA\Post(
     *     path="/api/phones",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Phone")         
     *     ), 
     *     @OA\Response(
     *         response="201",
     *         description="Un téléphone",
     *         @OA\JsonContent(ref="#/components/schemas/Phone")  
     *     ) 
     * )
     */
    public function createAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, ValidatorInterface $validator)
    {
        
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->json([
                'status' => 401,
                'message' => "Acces Denied"
            ], 401);
        }
        
        $jsonRecu = $request->getContent();

        try {
        $phone = $serializer->deserialize($jsonRecu, Phone::class, 'json');
        $phone->setDateAjoutAt(new \DateTime());

        $errors = $validator->validate($phone);

        if(count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $manager->persist($phone);
        $manager->flush();
        
        return $this->json($phone, 201, [], ['groups' => 'phone:read']);
        }catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
        
    }

    /**
     * @Route("/api/phones/{id}", name="app_phones_update", methods={"PUT"})
     * @OA\Put(
     *     path="/api/phones/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",     
     *         description="id du téléphone",
     *         required=true,
     *         @OA\Schema(type="integer")  
     *     ),   
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Phone")
     *     ), 
     *     @OA\Response(
     *         response="200",
     *         description="Un téléphone",
     *         @OA\JsonContent(ref="#/components/schemas/Phone")  
     *     ) 
     * )
     */
    public function updateAction(Phone $phone, Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, ValidatorInterface $validator)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->json([
                'status' => 401,
                'message' => "Acces Denied"
            ], 401);
        }
        
        try{
        
        $jsonRecu = $request->getContent();
        $phoneValidate = $serializer->deserialize($jsonRecu, Phone::class, 'json');
        
        $errors = $validator->validate($phoneValidate);
        
        if(count($errors) > 0) {
            return $this->json($errors, 400);
        }
        
        $form = $this->createForm(PhoneType::class, $phone);
        $data = json_decode($request->getContent(), true);
        $data['dateAjoutAt'] = $phone->getDateAjoutAt();
        
        $form->submit($data);
        $phone->setDateModifAt(new \DateTime());
        
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

        $manager->persist($phone);
        $manager->flush();

        return $this->json([
            'status' => 200,
            'message' => "le téléphone a bien été mis à jour"
        ], 200);
        
    }

     /**
     * @Route("/api/phones/{id}", name="app_phones_delete", methods={"DELETE"})
     * @OA\Delete(
     *     path="/api/phones/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",     
     *         description="id du téléphone",
     *         required=true,
     *         @OA\Schema(type="integer")  
     *     ),   
     *     @OA\Response(
     *         response="204",
     *         description="Un téléphone",
     *         @OA\JsonContent(ref="#/components/schemas/Phone")  
     *     ) 
     * )
     */
    public function deleteAction(Phone $phone, EntityManagerInterface $manager)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->json([
                'status' => 401,
                'message' => "Acces Denied"
            ], 401);
        }
        
        $manager->remove($phone);
        $manager->flush();
        
        return $this->json(null, 204);
    }

}




