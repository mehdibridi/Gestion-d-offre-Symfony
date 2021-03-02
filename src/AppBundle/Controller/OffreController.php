<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CategorieOffre;
use AppBundle\Entity\Condidats;
use AppBundle\Entity\Offres;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class OffreController extends Controller
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
     * @Route("/AjouterOffre", name="Offre_Ajouter")
     * @Template()
     */
    public function addOffres(Request $request){
        $user= $this->get('security.token_storage')->getToken()->getUser();
        if($user != "anon."){
            if (  $user->getUsername() == "admin") {
                $o = new Offres();
                    $form = $this->createFormBuilder($o)
                        ->add('categorieOffre', EntityType::class, array(
                            'class' => 'AppBundle:CategorieOffre',
                            'choice_label' => function (CategorieOffre $user) {
                                return sprintf(' %s', $user->getCategorie());
                            },
                            'expanded' => false,
                            'multiple' => false
                        ))
                        ->add('reference', TextType::class)
                        ->add('datePostulation', DateType::class)
                        ->add('description', TextareaType::class)
                        ->add('activite', TextareaType::class)
                        ->add('qualification', TextareaType::class)
                        ->add('competence', TextareaType::class)
                        ->add('Ajouter', SubmitType::class)
                        ->getForm();
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($o);
                        $em->flush();
                        return $this->redirect('GestionOffre');

                    }

                    return $this->render('default/FormOffre.html.twig', array(
                        'f' => $form->createView()
                    ));
                }
        }
        else return $this->redirect('Login');

    }
    /**
     * @Route("/ModifyCandidat", name="offre_Modify")
     * @Template()
     */
    public function Modifier(Request $request)
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();
        if($user != "anon."){
            if (  $user->getUsername() == "admin") {
                $id = $request->get('ModifyId');
                $re = $this->getDoctrine()->getRepository("AppBundle:Offres")->find($id);

                $o = new Offres();
                $form = $this->createFormBuilder($o)
                    ->add('categorieOffre', EntityType::class, array(
                        'class' => 'AppBundle:CategorieOffre',
                        'choice_label' => function (CategorieOffre $user) {
                            return sprintf(' %s', $user->getCategorie());
                        },
                        'choice_value' => function (CategorieOffre $entity = null) {
                            return $entity ? $entity->getCategorie() : '';
                        },
                        'expanded' => false,
                        'multiple' => false,

                    ))
                    ->add('reference', TextType::class)
                    ->add('datePostulation', DateType::class)
                    ->add('description', TextareaType::class)
                    ->add('activite', TextareaType::class)
                    ->add('qualification', TextareaType::class)
                    ->add('competence', TextareaType::class)
                    ->add('Modifier', SubmitType::class)
                    ->getForm();
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $post = $em->getRepository("AppBundle:Offres")->find($id);
                    $categorieOffre = $form['categorieOffre']->getData();
                    $reference = $form['reference']->getData();
                    $datePostulation = $form['datePostulation']->getData();
                    $description = $form['description']->getData();
                    $activite = $form['activite']->getData();
                    $qualification = $form['qualification']->getData();
                    $competence = $form['competence']->getData();

                    $post->setCategorieOffre($categorieOffre);
                    $post->setReference($reference);
                    $post->setDatePostulation($datePostulation);
                    $post->setDescription($description);
                    $post->setActivite($activite);
                    $post->setQualification($qualification);
                    $post->setCompetence($competence);

                    $em->flush();
                    return $this->redirect('GestionOffre');
                }


                return $this->render('default/FormModify.html.twig', array(
                    'f' => $form->createView(), 'offre' => $re
                ));
            }
        }
        else return $this->redirect('Login');

    }
    /**
     * @Route("/AllOffre", name="user_offre")
     * @Template()
     */
    public function AllOffre(Request $request){
        $p = $this->getDoctrine()->getRepository("AppBundle:Offres")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $resultat = $paginator->paginate(
            $p,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)

        );
        return $this->render('default/AllOffre.html.twig', array(
              'paginator' => $resultat)
        );
    }
    /**
     * @Route("/ListerOffre", name="offre_liste")
     * @Template()
     */
    public function ListerOffre(Request $request){
        $id = $request->get('offreId');
        $re = $this->getDoctrine()->getRepository("AppBundle:Offres")->find($id);
        return $this->render('default/ListerOffre.hml.twig', array(
                'liste' => $re)
        );
    }
    }