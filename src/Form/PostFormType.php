<?php
// src/Form/RegistrationFormType.php
namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostFormType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('titre', TextType::class, [
        'label' => false,
        'attr' => ['placeholder' => 'Entrez un titre'],
        'constraints' => [
          new NotBlank(),
        ],
      ])
      ->add('contenu', TextareaType::class, [
        'label' => false,
        'attr' => ['placeholder' => 'De quoi voulez vous parler?'],
        'constraints' => [
          new NotBlank(),
        ],
      ])

      ->add('image', FileType::class, [
        'label' => 'Ajouter une image',
        'mapped' => false,
        'required' => false,
        'constraints' => [
          new File([
            'maxSize' => '60M',
            'extensions' => ['png', "jpeg", 'gif', 'jpg'],
            'extensionsMessage' => 'Les fichier {{ extension }} ne sont pas supportés. Utilisez {{ extensions }}',
          ])
        ],
      ])

      ->add("add", SubmitType::class, ['label' => 'Poster']);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Post::class,
    ]);
  }
}
