<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CategorieOffre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class CategorieOffreController extends Controller
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
     * @Route("/AjouterCategorieOffre", name="CategorieOffre_Ajouter")
     * @Template()
     */
    public function addCategorieOffre(Request $request){
        if($this->get('security.token_storage')->getToken()->getUser() != "anon."){
            $user= $this->get('security.token_storage')->getToken()->getUser();
            if (  $user->getUsername() == "admin") {
                $o = new CategorieOffre();
                $form = $this->createFormBuilder($o)
                    ->add('categorie', TextType::class)
                    ->add('Ajouter', SubmitType::class)
                    ->getForm();

                $form->handleRequest($request);
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($o);
                    $em->flush();

                }
                return $this->render('default/FormCategorieOffre.html.twig', array(
                    'f' => $form->createView(),
                ));
            }
        }
        else return $this->redirect('Login');

    }
    /**
     * @Route("/ListerCategorieOffre", name="Lister_CategorieOffre")
     * @Template()
     */
    public function ListerCategorieOffre(Request $request)
    {
        if($this->get('security.token_storage')->getToken()->getUser() != "anon."){
            $user= $this->get('security.token_storage')->getToken()->getUser();
            if (  $user->getUsername() == "admin") {
                $p = $this->getDoctrine()->getRepository("AppBundle:CategorieOffre")->findAll();
                /**
                 * @var $paginator \Knp\Component\Pager\Paginator
                 */
                $paginator = $this->get('knp_paginator');
                $resultat = $paginator->paginate(
                    $p,
                    $request->query->getInt('page', 1),
                    $request->query->getInt('limit', 5)

                );


                //dump($request->get('apartmentId'));
                if (null !== $request->get('COffreId')) {
                    $id = $request->get('COffreId');
                    $re = $this->getDoctrine()->getRepository("AppBundle:CategorieOffre")->find($id);
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($re);
                    $em->flush();
                    return $this->redirect('ListerCategorieOffre');

                }


                return $this->render('default/ListerCategorieOffre.html.twig', array(
                        'f' => $resultat)
                );
            }
        }
        else return $this->redirect('Login');
    }
}