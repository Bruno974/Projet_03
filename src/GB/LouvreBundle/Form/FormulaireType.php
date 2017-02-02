<?php

namespace GB\LouvreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulaireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('calendrier', DateType::class, array('widget' => 'single_text',
                    // do not render as type="date", to avoid HTML5 date pickers
                    'html5' => true,
                    // add a class that can be selected in JavaScripts
                    'attr' => ['class' => 'datePicker'],))*/
           ->add('calendrier', DateType::class, array('widget' => 'single_text', 'html5' => true, 'format' => 'dd.MM.yyyy', 'attr' => ['class' => 'datePicker']))
            ->add('duree', ChoiceType::class, array('choices' => array(
                'Journee' => '1',
                'Demi-journee' => '2'),
                'multiple'=>false,'expanded'=>true))
            ->add('mail', EmailType::class)
            ->add('visiteurs', CollectionType::class,
                array(
                    'entry_type' => VisiteurType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    //'label' => ' '
                ))
            ->add('Valider', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GB\LouvreBundle\Entity\Formulaire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gb_louvrebundle_formulaire';
    }


}
