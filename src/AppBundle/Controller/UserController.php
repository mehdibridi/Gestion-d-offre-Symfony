<?php

namespace AppBundle\Controller;


use AppBundle\Entity\CategorieOffre;
use AppBundle\Entity\Offres;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/Inscription", name="security_Inscription")
     */
    public function Inscription(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user == "anon.") {

                $user = new User();
                $form = $this->createFormBuilder($user)
                    ->add('email', TextType::class)
                    ->add('password', PasswordType::class)
                    ->add('confirmation', PasswordType::class)
                    ->add('inscription', SubmitType::class)
                    ->getForm();
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $password = $form['password']->getData();
                    $hash = $encoder->encodePassword($user, $password);
                    $user->setPassword($hash);
                    $em->persist($user);
                    $em->flush();
                    return $this->redirect('Login');

                }

                return $this->render('default/Inscription.html.twig', array(
                    'form' => $form->createView()
                ));
        }
        else return $this->redirect('Deconnexion');

    }

    /**
     * @Route("/Login", name="security_login")
     */
    public function Login(Request $request, AuthenticationUtils $authenticationUtils)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        if(!$this->checkLogin()){
         return $this->render('default/Login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ));}
        else{
            return $this->checkLogin();
        }
    }
    /**
     * @Route("/checkLogin", name="security_checkLogin")
     */
    public function checkLogin(){
        if (true == $this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute('user_offre');
        }
        else if (true == $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('main_home');
        }
    }

    /**
     * @Route("/GestionUser", name="user_show")
     */
    public function gestionUser(Request $request){
        $user= $this->get('security.token_storage')->getToken()->getUser();
        if($user != "anon."){
            if (  $user->getUsername() == "admin") {
                $p = $this->getDoctrine()->getRepository("AppBundle:User")->findAll();
                /**
                 * @var $paginator \Knp\Component\Pager\Paginator
                 */
                $paginator  = $this->get('knp_paginator');
                $resultat = $paginator->paginate(
                    $p,
                    $request->query->getInt('page',1),
                    $request->query->getInt('limit',3)

                );
                //dump($request->get('apartmentId'));
                if (null !== $request->get('apartmentId')){
                    $id = $request->get('apartmentId');
                    $re = $this->getDoctrine()->getRepository("AppBundle:User")->find($id);
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($re);
                    $em->flush();
                    return  $this->redirect('GestionUser');
                }
                return $this->render('default/GestionDesUser.html.twig', array(
                        'f' => $resultat)
                );
            }
        }
        else return $this->redirect('Login');
    }
    /**
     * @Route("/Deconnexion", name="security_logout")
     */
    public function logOut()
    {
    }

}