<?php

namespace App\Controller;

use App\Entity\EmpruntLivres;
use App\Entity\Livre;
use App\Repository\EmpruntLivresRepository;
use App\Repository\LivreRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;

class EmpruntLivresController extends AbstractController
{
    /**
     * @Route("/emprunt/livres", name="emprunt_livres")
     */
    public function index(UserInterface $userInterface,EmpruntLivresRepository $empruntLivresRepository): Response
    {
        return $this->render('emprunt_livres/index.html.twig', [
            'EmpruntLivres' => $empruntLivresRepository->findUserEmprunts($userInterface),
        ]);
    }
    /**
     * @Route("/agent/emprunt/livres", name="agent_emprunt_livres")
     */
    public function get_liste_des_emprunts(EmpruntLivresRepository $empruntLivresRepository): Response
    {
        return $this->render('emprunt_livres/index.html.twig', [
            'EmpruntLivres' => $empruntLivresRepository->findAll(),
        ]);
    }
    /**
     * @Route("/emprunt/livres/annuler_reservation", name="annuler_reserver_livre")
     */
    public function annuler_reservation_livre(UserInterface $userInterface,Request $request,EmpruntLivresRepository $empruntLivresRepository, LivreRepository $livreRepository): Response
    {
        $livreEmp_id = $request->get('livreEmp');
        $livre = $livreRepository->findOneBy(['id'=>$livreEmp_id]);
        $livreEmp = $empruntLivresRepository->findOneBy(['Livre'=>$livre]);
        //$empruntLivresRepository->delete_Emprunt($userInterface, $livre);
        //dump($livreEmp); die();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($livreEmp);
        $entityManager->flush();
        $this->addFlash('success', 'la reservation du livre '.$livre->getTitre().' a été annulée');
        return $this->redirectToRoute('livre_index');
    }
    /**
     * @Route("/emprunt/livres/reserver", name="reserver_livre")
     */
    public function reserver_livre(UserInterface $userInterface, Request $request,EmpruntLivresRepository $empruntLivresRepository, LivreRepository $livreRepository): Response
    {
        $list = $empruntLivresRepository->findWeeklyUserEmprunts($userInterface);
        if(sizeof($list)<3) {
            $livreEmp_id = $request->get('livreEmp');
            $livreEmp = $livreRepository->findOneBy(['id' => $livreEmp_id]);
            $newEmpruntLivre = new EmpruntLivres();
            $newEmpruntLivre->setUser($userInterface);
            $newEmpruntLivre->setLivre($livreEmp);
            $newEmpruntLivre->setState("en_attente");
            $newEmpruntLivre->setDateDeReservation(new \DateTime("now"));
            //dump($newEmpruntLivre);die();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newEmpruntLivre);
            $entityManager->flush();
            $this->addFlash('success', 'Votre demande de reservation du livre '.$livreEmp->getTitre().' a été effectuée');

        }else{
            $this->addFlash('error', 'Vous avez déjà reservé 3 livres dans les derniéres 7 jours, essayez ultérirement');
        }
       // return $this->json(["data"=>"test"]);
        return $this->redirectToRoute('livre_index');
    }
    /**
     * @Route("agent/emprunt/livres/retour", name="confirmer_retour_livre")
     */
    public function retour_livre(UserInterface $userInterface, Request $request,EmpruntLivresRepository $empruntLivresRepository, LivreRepository $livreRepository): Response
    {
        $livreEmp_id = $request->get('livreEmp');
        $livreEmpunté = $empruntLivresRepository->findOneBy(['id'=>$livreEmp_id]);
        $livreEmpunté->setState("reçu");
        $livre = $livreEmpunté->getLivre();
        $nbExemplaires = $livre->getNbExemplaires();
        $livre->setNbExemplaires($nbExemplaires+1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('agent_emprunt_livres');
    }

    /**
     * @Route("/agent/emprunt/livres/confirmer", name="confirmer_envoie_livre")
     */
    public function confirmer_envoie_livre( Request $request,EmpruntLivresRepository $empruntLivresRepository, LivreRepository $livreRepository): Response
    {
        $livreEmp_id = $request->get('livreEmp');
        $livreEmp = $empruntLivresRepository->findOneBy(['id'=>$livreEmp_id]);
        $livreEmp->setState('sent');
        $livreEmp->getLivre()->setNbExemplaires($livreEmp->getLivre()->getNbExemplaires()-1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($livreEmp);
        $entityManager->flush();
        return $this->redirectToRoute('agent_emprunt_livres');
    }

}
