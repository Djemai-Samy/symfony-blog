<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AvatarFormType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('avatar', FileType::class, [
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
      ->add('upload', SubmitType::class);
  }

  public function configureOptions(OptionsResolver $resolver): void {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
