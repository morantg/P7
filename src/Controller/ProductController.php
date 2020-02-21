<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProductController extends AbstractController
{
    /**
     * @Get(
     *     path = "api/products/{id}",
     *     name = "app_product_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View
     */
    public function showAction(Product $product)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux administrateurs.');
          }
        return $product;
    }
}
