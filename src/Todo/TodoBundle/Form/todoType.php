<?php

namespace Todo\TodoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class todoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        //ici c notre formulaire le html est fini!!!
        $builder
                ->add('nom')
                ->add('description','textarea')
                ->add('date','datetime')
                ->add('Valider','submit')
                ->add('Retour','reset');
    }

    public function getName() {
        return 'asmaa_asmaabundle_test';
    }

}