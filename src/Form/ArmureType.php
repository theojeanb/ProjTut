<?php

namespace App\Form;

use App\Entity\Armure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArmureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('defense')
            ->add('rarete')
            ->add('type')
            ->add('sprite', FileType::class, [
                'label' => 'Sprite (PNG)',
                'mapped' => false,
                'attr' => array(
                    'class' => 'form-control-file'
                ),
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid png document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Armure::class,
        ]);
    }
}
