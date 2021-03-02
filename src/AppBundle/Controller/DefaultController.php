<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Condidats;
use AppBundle\Entity\Offres;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\PropertyAccess\PropertyAccess;


class DefaultController extends Controller
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
     * @Route("/GestionOffre", name="offre_show")
     * @Template()
     */
    public function gestionDesOffres(Request $request){
        $user= $this->get('security.token_storage')->getToken()->getUser();
        if($user != "anon."){
            if (  $user->getUsername() == "admin") {
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
                //dump($request->get('apartmentId'));
                if (null !== $request->get('apartmentId')){
                    $id = $request->get('apartmentId');
                    $re = $this->getDoctrine()->getRepository("AppBundle:Offres")->find($id);
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($re);
                    $em->flush();
                    return  $this->redirect('GestionOffre');
                }
                if (null !== $request->get('ModifyId')){
                    return  $this->redirect('ModifyCandidat');
                }
                return $this->render('default/GestionDesOffres.html.twig', array(
                        'f' => $resultat)
                );
            }
        }
        else return $this->redirect('Login');
    }

    /**
     * @Route("/GestionCondidat", name="Condidat_show")
     * @Template()
     */
    public function gestionDesCondidat(Request $request){
        $user= $this->get('security.token_storage')->getToken()->getUser();
        if($user != "anon."){
            if (  $user->getUsername() == "admin") {
                $p = $this->getDoctrine()->getRepository("AppBundle:Condidats")->findAll();
                /**
                 * @var $paginator \Knp\Component\Pager\Paginator
                 */
                $paginator = $this->get('knp_paginator');
                $resultat = $paginator->paginate(
                    $p,
                    $request->query->getInt('page', 1),
                    $request->query->getInt('limit', 5)

                );


                if (null !== $request->get('condidatId')) {
                    $id = $request->get('condidatId');
                    $re = $this->getDoctrine()->getRepository("AppBundle:Condidats")->find($id);
                    if ($re->getCurriculumVitae()) {
                        $path = "C:\wamp64\www\untitled1\public\FileUploader\cv";
                        $filesystem = new Filesystem();
                        $filesystem->remove($path . '\\' . $re->getCurriculumVitae());
                    }
                    if ($re->getLettreeMotivation()) {
                        $path = "C:\wamp64\www\untitled1\public\FileUploader\Lettre de motivation";
                        $filesystem = new Filesystem();
                        $filesystem->remove($path . '\\' . $re->getLettreeMotivation());
                    }
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($re);
                    $em->flush();
                    return $this->redirect('GestionCondidat');
                }


                return $this->render('default/OffreCondidat.html.twig', array(
                        'f' => $resultat)
                );
            }
        }
        else return $this->redirect('Login');

    }
    /**
     * @Route("Excel", name="Exel_show")
     * @Template()
     */
    public function excel()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user != "anon.") {
            if ($user->getUsername() == "admin") {
                $i = 1;
                $j = 1;
                $k = 1;
                $propertyAccessor = PropertyAccess::createPropertyAccessor();

                $nom = $this->getDoctrine()->getRepository("AppBundle:Condidats")->findAllNom();
                $prenom = $this->getDoctrine()->getRepository("AppBundle:Condidats")->findAllNom();
                $description = $this->getDoctrine()->getRepository("AppBundle:Condidats")->findAllDescription();
                $courriel = $this->getDoctrine()->getRepository("AppBundle:Condidats")->findAllCourriel();
                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

                $phpExcelObject->getProperties()->setCreator("liuggio")
                    ->setLastModifiedBy("Giulio De Donato")
                    ->setTitle("Office 2005 XLSX Test Document")
                    ->setSubject("Office 2005 XLSX Test Document")
                    ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
                    ->setKeywords("office 2005 openxml php")
                    ->setCategory("Test result file");
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Condidat');
                foreach ($nom as $condidat) {
                    $i = $i + 1;
                    $a = "A" . $i;
                    foreach ($prenom as $condidatPrenom) {
                        $phpExcelObject->setActiveSheetIndex(0)
                            ->setCellValue($a, $condidat->getNom() . ' ' . $condidatPrenom->getPrenom());

                    }

                }
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('B1', 'Offre');
                foreach ($description as $offre) {
                    $j = $j + 1;
                    $b = "B" . $j;
                    $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue($b, $propertyAccessor->getValue($offre, '[description]'));

                }
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('C1', 'Courriel');
                foreach ($courriel as $condidatCourriel) {
                    $k = $k + 1;
                    $c = "C" . $k;
                    $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue($c, $condidatCourriel->getCourriel());

                }
                $phpExcelObject->getActiveSheet()->setTitle('Simple');
                $phpExcelObject->setActiveSheetIndex(0);

                $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                $response = $this->get('phpexcel')->createStreamedResponse($writer);
                $dispositionHeader = $response->headers->makeDisposition(
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                    'stream-file.xls'
                );
                $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                $response->headers->set('Pragma', 'public');
                $response->headers->set('Cache-Control', 'maxage=1');
                $response->headers->set('Content-Disposition', $dispositionHeader);

                return $response;
            }
        }
        return $this->redirect('GestionCondidat');

    }
    /**
     * @Route("/main", name="main_home")
     * @Template()
     */
    public function main(Request $request){

        $user= $this->get('security.token_storage')->getToken()->getUser();
        if($user != "anon."){
            if (  $user->getUsername() == "admin") {
                return $this->render('default/main.html.twig', array());
            }
        }
        else return $this->redirect('Login');


    }
    /**
     * @Route("cv", name="cv_show")
     * @Template()
     */
    public function ListerCv(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user != "anon.") {
            if ($user->getUsername() == "admin") {
                $id = $request->get('condidatId');
                $entity = $this->getDoctrine()->getRepository("AppBundle:Condidats")->find($id);
                $stream = fopen('C:\wamp64\www\untitled1\public\FileUploader\cv\\' . $entity->getCurriculumVitae(), 'r');
                $response = new Response(stream_get_contents($stream), 200, array(
                    'Content-Type' => 'application/pdf',

                ));
                return $response;
            }
        }
        else return $this->redirect('Login');

    }
    /**
     * @Route("ListerLM", name="LM_show")
     * @Template()
     */
    public function ListerLM(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user != "anon.") {
            if ($user->getUsername() == "admin") {
                $id = $request->get('condidatId');
                $entity = $this->getDoctrine()->getRepository("AppBundle:Condidats")->find($id);
                $stream = fopen('C:\wamp64\www\untitled1\public\FileUploader\Lettre de motivation\\' . $entity->getLettreeMotivation(), 'r');
                $response = new Response(stream_get_contents($stream), 200, array(
                    'Content-Type' => 'application/pdf',

                ));
                return $response;
            }
        }
        else return $this->redirect('Login');

    }
    /**
     * @Route("/Home", name="accueille_home")
     * @Template()
     */
    public function Home(Request $request){

        $user= $this->get('security.token_storage')->getToken()->getUser();
        if($user == "anon."){

                return $this->render('default/Home.html.twig', array());
        }
        else return $this->redirect('Login');


    }
}