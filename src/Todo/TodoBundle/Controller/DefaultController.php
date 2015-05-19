<?php

namespace Todo\TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Todo\TodoBundle\Entity\Taches;
use Todo\TodoBundle\Form\todoType;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TodoBundle:Default:index.html.twig', array('name' => $name));
    }
    
    //formulaire
    
    public function ajtFormulaireAction()
    {
       $form = $this->createForm(new todoType());
       
       return $this->render('TodoBundle:Default:todoformulaire.html.twig' , array('form' => $form ->createView()));
    }
    
    //traitement form
    
    public function traitmentFormulaireAction() {
        $form = $this->createForm(new todoType());

        if ($this->get('request')->getMethod() == 'POST') {
            $form->bind($this->get('request'));
            
            if ($form->isValid()) {
                $tache = new Taches();
                $tache->setNom($form['nom']->getData());
                $tache->setDescription($form['description']->getData());
                $tache->setDate($form['date']->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($tache);
                $em->flush();
                
               $em = $this->getDoctrine()->getManager();
               $taches = $em->getRepository('TodoBundle:Taches')->findAll();
             foreach ($taches as $tache) {
                    $date = $tache->getDate()->format('Y-m-d H:i:s');
                    $dateactuel = new \DateTime('now');
                    $dt= $dateactuel->format('Y-m-d H:i:s');
                    if($date < $dt){
                        
                        
                      $em->remove($tache);
                      $em->flush();
                      //  $taches = $em->getRepository('TodoBundle:Taches')->findAll();
                        // return $this->render('TodoBundle:Default:acceuil.html.twig', array('taches' => $taches));
                    }
                    
                    
                }
                
            }
        }
        $em = $this->getDoctrine()->getManager();
        $taches = $em->getRepository('TodoBundle:Taches')->findAll();
                
                  return $this->render('TodoBundle:Default:acceuil.html.twig', array('taches' => $taches));
    }
    
    public function detailTacheAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();
		$details = $em->getRepository('TodoBundle:Taches')->find($id);
		 if (!$details) {
        throw $this->createNotFoundException('Aucun details trouvé' );}
			
        return $this->render('TodoBundle:Default:detailsTache.html.twig' , array('details' => $details));
    }
    
    //acceuil
    public function acceuilAction()
    {
        
         $em = $this->getDoctrine()->getManager();
               $taches = $em->getRepository('TodoBundle:Taches')->findAll();
               foreach ($taches as $tache) {
                    $date = $tache->getDate()->format('Y-m-d H:i:s');
                    $dateactuel = new \DateTime('now');
                    $dt= $dateactuel->format('Y-m-d H:i:s');
                    if($date < $dt){
                        $em->remove($tache);
                        $em->flush();
                        $taches = $em->getRepository('TodoBundle:Taches')->findAll();
                         return $this->render('TodoBundle:Default:acceuil.html.twig', array('taches' => $taches));
                    }
                    else
                         return $this->render('TodoBundle:Default:acceuil.html.twig', array('taches' => $taches));
                    
                    
                }
            
    }
}
