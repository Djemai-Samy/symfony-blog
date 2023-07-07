<?php
// /src/Controller/MonController.php
namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// 1. Renommer la classe
class HomeController extends AbstractController {

  #[Route('/', name: 'home', methods: ['GET'])]

  function index(PostRepository $postRepo): Response {

    $posts = $postRepo->findAll();

    return $this->render('home/home.html.twig', ["posts"=>$posts]);
  }
}
