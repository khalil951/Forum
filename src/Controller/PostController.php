<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\Room;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;



#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();

        // Retrieve available rooms from the database
        $rooms = $entityManager->getRepository(Room::class)->findAll();
    
        $form = $this->createForm(PostType::class, $post, [
            'rooms' => $rooms,
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
             // Handle file upload for profile picture
            
             $file = $form->get('img_url')->getData();
             if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                 try {
                     $file->move('/Applications/XAMPP/xamppfiles/htdocs/uploads' , $fileName); 
                     $post->setImgUrl($fileName);
                 } catch (FileException $e) {
                     // Handle file upload error
                     $this->addFlash('error', 'Failed to upload the file.');
                     return $this->redirectToRoute('app_post_new');
                 }
                }
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }
    
            // Fetch the corresponding Room entity from the database
        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        $room = $post->getRoom();
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'room' => $room,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $rooms = $entityManager->getRepository(Room::class)->findAll();
        $form = $this->createForm(PostType::class, $post, [
            'rooms' => $rooms,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('img_url')->getData();
             if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                 try {
                     $file->move('/Applications/XAMPP/xamppfiles/htdocs/uploads' , $fileName); 
                     $post->setImgUrl($fileName);
                 } catch (FileException $e) {
                     // Handle file upload error
                     $this->addFlash('error', 'Failed to upload the file.');
                     return $this->redirectToRoute('app_post_edit');
                 }
                }
            $entityManager->flush();
            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }
        $room = $post->getRoom();
        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
            'room' => $room,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
    }


}
