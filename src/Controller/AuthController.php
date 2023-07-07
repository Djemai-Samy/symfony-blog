<?php
// /src/Controller/MonController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

// 1. Renommer la classe
class AuthController extends AbstractController {

  #[Route('/register', name: 'register')]
  function register(Request $req,  UserPasswordHasherInterface $passwordHasher, UserRepository $userRepo): Response {

    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->redirectToRoute('profil');
    }


    $user = new User();

    $formulaire = $this->createForm(RegistrationFormType::class, $user);

    $formulaire->handleRequest($req);

    if($formulaire->isSubmitted() && $formulaire->isValid()){

      // Hasher le mot de passe
      $passwordHash = $passwordHasher->hashPassword($user, $user->getPassword());
      
      // Mettre a jour le mot de passe de user la hasher
      $user->setPassword($passwordHash);

      // Enregistrer l'utilisateur
      $userRepo->save($user);

      // Rediriger vers la page de connexion
      return $this->redirectToRoute('login');
      
    }

    return $this->render('auth/register.html.twig', ['formulaire'=>$formulaire]);
  }

  #[Route('/login', name: 'login')]
  function login(): Response {

    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->redirectToRoute('profil');
    }
    return $this->render('auth/login.html.twig');
  }

  #[Route('/logout', name: 'logout')]
  function logout() {
    
    // Rien a mettre

  }
}
