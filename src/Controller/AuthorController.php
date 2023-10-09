<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
    );

    #[Route('/authorList', name: 'author_list')]
    public function list(): Response
    {
        return $this->render('author/list.html.twig', [
            'authors' => $this->authors
        ]);
    }

    #[Route('/details/{id}', name: "author_details")]
    public function details($id):Response 
    {
        return $this->render('author/details.html.twig', [
            'authors' => $this->authors,
            'id' => $id
        ]);
    }

    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/authorShow/{name}', name: 'author_show')]
    public function show($name): Response
    {
        return $this->render('author/show.html.twig', [
            'n' => $name
        ]);
    }
}
