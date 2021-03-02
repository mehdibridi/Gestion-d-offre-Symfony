<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;



class ContactController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/AjouterContact", name="Contact_Ajouter")

     */
    public function AddContact(Request $request,\Swift_Mailer $mailer){
        $user= $this->get('security.token_storage')->getToken()->getUser();
        if($user != "anon.") {
            if ($user->getUsername() == "admin") {
                $contact = new Contact();
                $form = $this->createFormBuilder($contact)
                    ->add('email', TextType::class)
                    ->add('sujet', TextareaType::class)
                    ->add('objet', TextType::class)
                    ->add('Ajouter', SubmitType::class)
                    ->getForm();
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($contact);
                    $em->flush();
                    $email = $form['email']->getData();
                    $sujet = $form['sujet']->getData();
                    $objet = $form['objet']->getData();
                    $uesername = 'mehdi_maha@outlook.com';
                    $message = (new \Swift_Message())
                        ->setSubject($sujet)
                        ->setFrom($uesername)
                        ->setTo($email)
                        ->setBody($objet);
                    $mailer->send($message);

                }
                // $mailer->send($message);

                return $this->render('default/formContact.html.twig', array(
                    'f' => $form->createView()
                ));
            }
        }
        else return $this->redirect('Login');

    }
    /**
     * @Route("/ListerEmail", name="Lister_Email")

     */
    public function ListerEmail(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user != "anon.") {
            if ($user->getUsername() == "admin") {
                $em = $this->getDoctrine()->getRepository("AppBundle:Contact")->findAll();
                /**
                 * @var $paginator \Knp\Component\Pager\Paginator
                 */
                $paginator = $this->get('knp_paginator');
                $resultat = $paginator->paginate(
                    $em,
                    $request->query->getInt('page', 1),
                    $request->query->getInt('limit', 4)

                );
                if (null !== $request->get('apartmentId')){
                    $id = $request->get('apartmentId');
                    $re = $this->getDoctrine()->getRepository("AppBundle:Contact")->find($id);
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($re);
                    $em->flush();
                    return  $this->redirect('ListerEmail');
                }
                return $this->render('default/ListerEmail.html.twig', array(
                    'f' => $resultat
                ));
            }
        }
        else return $this->redirect('Login');
    }
}