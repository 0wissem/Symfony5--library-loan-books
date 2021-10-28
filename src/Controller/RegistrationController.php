<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\Instantiator\Exception\ExceptionInterface;
use mysql_xdevapi\Exception;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register", methods={"GET"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        //$form = $this->createForm(RegistrationFormType::class, $user);
       // $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            // encode the plain password
//            $user->setPassword(
//                $passwordEncoder->encodePassword(
//                    $user,
//                    $form->get('plainPassword')->getData()
//                )
//            );
//
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
//            // do anything else you need here, like send an email
//
//            return $this->redirectToRoute('home_page');
//        }

        return $this->render('registration/register.html.twig',
            ['id'=>'']
           // 'registrationForm' => $form->createView(),
        );
    }
    /**
     * @Route("/register", name="verif_registration", methods={"POST"})
     */
    public function get_registration(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $prenom = $request->get('prenom');
        $nom = $request->get('nom');
        $email = $request->get('email');
        $password = $request->get('pwd');
        $role = $request->get('role');
        $user->setFirstName($prenom);
        $user->setLastName($nom);
        $user->setEmail($email);
        //dump($role);die();
        $user->setRoles(array($role));
        $user->setPassword( $passwordEncoder->encodePassword(
                   $user,
                    $password));
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('login');
        }catch (\Doctrine\DBAL\Exception $e){
            $error = $e->getPrevious()->getPrevious()->getMessage();
            return $this->render('registration/register.html.twig',['id'=>$error]);
        }
    }
}
