<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\AuteurRepository;
use App\Repository\CategorieRepository;
use App\Repository\EditeurRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(Request $request,LivreRepository $livreRepository, CategorieRepository $categorieRepository): Response
    {

        $selectedCategoryId = $request->query->get('category_id');
        if($selectedCategoryId==null or $selectedCategoryId==0){
            return $this->render('livre/index.html.twig', [
                'livres' => $livreRepository->findAll(),
                'categories' => $categorieRepository->findAll()
            ]);
        }else {
            return $this->render('livre/index.html.twig', [
                'livres' => $livreRepository->findBy(['categorie'=>$selectedCategoryId]),
                'categories' => $categorieRepository->findAll()
            ]);
        }


    }
    /**
     * @Route("/advanced_filter", name="advanced_filter", methods={"GET"})
     */
    public function advanced_filter(EditeurRepository $editeurRepository,AuteurRepository $auteurRepository,LivreRepository $livreRepository, CategorieRepository $categorieRepository): Response
    {
        // $selectedCategoryId = $request->query->get('category_id');
        return $this->render('livre/filter.html.twig', [
            'livres' => $livreRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
            'auteurs' => $auteurRepository->findAll(),
            'editeurs' => $editeurRepository->findAll()
        ]);
    }
    /**
     * @Route("/advanced_filter", name="advanced_filter2", methods={"POST"})
     */
    public function advanced_filter_post(Request $request,EditeurRepository $editeurRepository,AuteurRepository $auteurRepository,LivreRepository $livreRepository, CategorieRepository $categorieRepository): Response
    {
        // $selectedCategoryId = $request->query->get('category_id');
//        return $this->render('livre/filter.html.twig', [
//            'livres' => $livreRepository->findAll(),
//            'categories' => $categorieRepository->findAll(),
//            'auteurs' => $auteurRepository->findAll(),
//            'editeurs' => $editeurRepository->findAll()
//        ]);
        $title = $request->get('title');
        $prixMin = $request->get('prix_min');
        $prixMax =  $request->get('prix_max');
        $dateMin = $request->get('date_min');
        $dateMax = $request->get('date_max');
        $category_id = $request->get("category_id");
        $editeur_id = $request->get("editeur_id");
        $auteur_id = $request->get("auteur_id");

        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->advaned_filter_request($title,$dateMin,$dateMax,(int)$prixMin, (int)$prixMax, (int)$category_id, (int) $editeur_id, (int)$auteur_id),
            'categories' => $categorieRepository->findAll(),
            //'auteurs' => $auteurRepository->findAll(),
            //'editeurs' => $editeurRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="livre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }
    /**
     *  @Route("/livreprix/{prix}", name="livre_Prix")
     */
    public function livrePrix(float $prix = -1): Response
    {
        if($prix == -1) return $this->redirectToRoute('livre_index');
        else {$em = $this->getDoctrine()->getManager();
        $repLivre = $em ->getRepository(Livre::class);
       // $lesLivres = $repLivre->findBy(["prix"=>$prix]);
            $lesLivres = $repLivre->findByPrixMoreThan($prix);
        return  $this->render('livre/index.html.twig',['livres'=> $lesLivres]);}
    }


    /**
     * @Route("/{id}", name="livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete", methods={"POST"})
     */
    public function delete(Request $request, Livre $livre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            //dump($livre); die();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }


}
