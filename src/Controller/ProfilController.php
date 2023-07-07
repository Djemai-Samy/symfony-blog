<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\AvatarFormType;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController {

  #[Route('/profil', name: 'profil')]
  function index(Request $req, PostRepository $postRepo, SluggerInterface $slugger, UserRepository $userRepo): Response {

    $post = new Post();

    $postFormulaire = $this->createForm(PostFormType::class, $post);

    $avatarForm = $this->createForm(AvatarFormType::class);

    $postFormulaire->handleRequest($req);

    if ($postFormulaire->isSubmitted() && $postFormulaire->isValid()) {

      $imagePost = $postFormulaire->get('image')->getData();

      if($imagePost){
        $imageName = $this->uploadFile($imagePost, $slugger, 'post_directory');
        $post->setImage($imageName);
      }

      $post->setUser($this->getUser());

      $postRepo->save($post);
    }
    
    $avatarForm->handleRequest($req);
    if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {

      $avatarFile = $avatarForm->get('avatar')->getData();
      
      if ($avatarFile) {
        /** @var User $user */
        $user = $this->getUser();
        
        $avatarName = $this->uploadFile($avatarFile, $slugger);

        $user->setAvatar($avatarName);

        $userRepo->save($user);

      }
    }

    return $this->render('profil/profil.html.twig', [
      'postFormulaire' => $postFormulaire,
      'avatarForm' => $avatarForm
    ]);
  }

  public function uploadFile($file, $slugger, $dossier = 'avatars_directory') {

    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

    $safeFilename = $slugger->slug($originalFilename);

    $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

    $file->move(
      $this->getParameter($dossier),
      $newFilename
    );

    return $newFilename;
  }
}
