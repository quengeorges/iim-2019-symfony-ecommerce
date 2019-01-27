<?php
/**
 * Created by PhpStorm.
 * User: Banji
 * Date: 27/01/2019
 * Time: 23:22
 */

namespace App\Controller;


use App\Entity\Collection;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CollectionController extends AbstractController
{
    /**
     * @Route("/collection/{slug}", name="collection", methods={"GET"})
     */
    public function index($slug)
    {
        $repositoryP = $this->getDoctrine()->getRepository(Collection::class);
        $collection     = $repositoryP->findOneBy([
            'slug' => $slug
        ]);
        $collections = $repositoryP->findAll();

        $repositoryP = $this->getDoctrine()->getRepository(Product::class);
        $product     = $repositoryP->findBy([
            'collection' => $collection->getId()
        ]);

        if (!$collection instanceof Collection) {
            throw new NotFoundHttpException('Product not found');
        }

        return $this->render('collection/index.html.twig', [
            'collection' => $collection,
            'collections' => $collections,
            'products' => $product
        ]);
    }
}