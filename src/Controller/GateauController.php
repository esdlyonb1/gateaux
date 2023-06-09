<?php

namespace App\Controller;

use App\Entity\Gateau;
use App\Entity\Image;
use App\Entity\Ingredient;
use App\Form\GateauType;
use App\Repository\GateauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GateauController extends AbstractController
{
    #[Route('/gateau', name: 'app_gateau')]
    public function index(GateauRepository $repository): Response
    {
        return $this->render('gateau/index.html.twig', [
            'gateaux' => $repository->findAll(),
        ]);
    }

    #[Route('/gateau/create', name: 'app_gateau_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $gateau = new Gateau();
        $formGateau = $this->createForm(GateauType::class, $gateau);
        $formGateau->handleRequest($request);
        if($formGateau->isSubmitted() && $formGateau->isValid()){

            $ingredients = $formGateau->getData()->getIngredients();

            foreach($ingredients as $ingredient){

                $newIngredient = new Ingredient();
                $newIngredient->setName($ingredient->getName());
                $newIngredient->setGateau($gateau);

            }

            $images = $formGateau->getData()->getImages();

            foreach($images as $image){

                $image->setGateau($gateau);

            }


            $manager->persist($gateau);
            $manager->flush();



        }


        return $this->renderForm('gateau/create.html.twig', [
            'formGateau' => $formGateau,
        ]);
    }

    #[Route('/gateau/{id}', name: 'app_gateau_show')]
    public function show(Gateau $gateau): Response
    {
        return $this->render('gateau/show.html.twig', [
            'gateau' => $gateau,
        ]);
    }
}
