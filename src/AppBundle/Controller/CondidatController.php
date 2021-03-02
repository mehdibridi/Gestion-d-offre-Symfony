<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Condidats;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class CondidatController extends Controller
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
     * @Route("/AjouterCondidat", name="offre_id")
     * @Template()
     */
    public function addCondidats(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user != "anon." && $user != "admin") {

            $c = new Condidats();
            $id = $request->get('offre_id');
            $form = $this->createFormBuilder($c)
                ->add('sourceDeCandidature', ChoiceType::class, [
                    'choices' => [
                        '---' => null,
                        'Forums de recrutement' => null,
                        'Réseaux sociaux' => null,
                        'Site web de l entreprise ' => null,
                        'Sites web des services publics' => null,
                    ],
                ])
                ->add('cin', TextType::class)
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('courriel', TextType::class)
                ->add('situationFamiliale', TextType::class)
                ->add('dateDeNaissance', DateType::class)
                ->add('villeDeNaissance', TextType::class)
                ->add('nationalite', TextType::class)
                ->add('adresse', TextType::class)
                ->add('codepostal', TextType::class)
                ->add('ville', TextType::class)
                ->add('pays', TextType::class)
                ->add('numeroDeTelephone', TextType::class)
                ->add('disponibilite', ChoiceType::class, [
                    'choices' => [
                        '---' => null,
                        'Imediate' => null,
                        'Autre' => null,
                    ],
                ])
                ->add('dateDeDisponibilite', DateType::class)
                ->add('curriculumVitae', FileType::class)
                ->add('lettreeMotivation', FileType::class)
                ->add('Ajouter', SubmitType::class)
                ->getForm();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $re = $this->getDoctrine()->getRepository("AppBundle:Offres")->find($id);
                $curriculumVitae = $form['curriculumVitae']->getData();
                $lettreeMotivation = $form['lettreeMotivation']->getData();
                if ($curriculumVitae) {
                    $cv = $this->uploadCv($curriculumVitae);
                    $c->setCurriculumVitae($cv);

                }
                if ($lettreeMotivation) {
                    $lettre = $this->upload($lettreeMotivation);
                    $c->setLettreeMotivation($lettre);

                }


                $c->addOffre($re);
                $em = $this->getDoctrine()->getManager();

                $em->persist($c);
                $em->flush();
             return $this->redirect('Login');

            }

            return $this->render('default/FormCondidat.html.twig', array(
                'f' => $form->createView(),
            ));
        }
        else return $this->redirect('Login');

    }

    public function uploadCv(UploadedFile $file){
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('brochures_directory_cv'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

        return $newFilename;
    }
    public function upload(UploadedFile $file){

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }


        return $newFilename ;
    }

}