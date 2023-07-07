<?php

namespace App\Form;

use App\Entity\Aliment;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AlimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'constraints' => new Length([
                'min' => 3, 'minMessage' => 'le nom doit faire 3 caractères minimum',
                'max' => 15 , 'maxMessage' => 'Le nom doit faire moins de 15 caractères'
               ])
            ])
        ->add('prix', IntegerType::class, [
            'constraints' => new Length([
                'min' => 0.1, 'minMessage' => 'Le prix doit être supérieur à 0.1',
                'max' => 100 , 'maxMessage' => 'Le prix doit être inférieur à 100'
               ])
            ] )
        ->add('imageFile',FileType::class,['required'=>false])
        ->add('calorie',IntegerType::class)
        ->add('proteines',IntegerType::class)
        ->add('glucides',IntegerType::class)
        ->add('lipides',IntegerType::class)
        ->add('type',EntityType::class,[
            'class' => Type::class,
            'choice_label' => 'libelle'
        ])
        ;

        // ->add('firstname', TextType::class,[
        //     'label' => 'Votre Prénom',
        //     'attr' => [
        //         'placeholder' => 'Merci de saisir votre prénom'
        //     ],
        //     'constraints' => new Length([
        //         'min' => 2, 'minMessage' => 'Veuillez saisir minimun 2 caractères',
        //         'max' => 60 , 'maxMessage' => 'Le nombre maximal de caractères autorisés est 60'
        //         ])
        // ])
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aliment::class,
        ]);
    }
}
