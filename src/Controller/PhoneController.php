<?php

namespace App\Controller;

use App\Entity\Phone;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PhoneController extends AbstractController
{
    /**
     * @Get("api/phones", name="app_phones_list")
     * @View()
     */
    public function listAction()
    {
        $phones = $this->getDoctrine()->getRepository(Phone::class)->findAll();
        
        return $phones;
    }
}
