<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\Room;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;



#[Route('/room/{room_id}/posts')]
class PostController extends AbstractController
{
    // #[Route('/', name: 'app_post_index', methods: ['GET'])]
    // public function index(PostRepository $postRepository): Response
    // {
    //     return $this->render('post/index.html.twig', [
    //         'posts' => $postRepository->findAll(),
    //     ]);
    // }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, RoomRepository $roomRepository, int $room_id): Response
    {
    $post = new Post();

    $room = $roomRepository->find($room_id);
 
    $form = $this->createForm(PostType::class, $post, [
        'room' => $room,
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
                 // Redirect to the new post form with the room_id parameter
                return $this->redirectToRoute('app_post_new', ['room_id' => $room_id]);
             }
            }

        // Set the room for the post
        $post->setRoom($room);
        $entityManager->persist($post);
        $entityManager->flush();
        // Redirect to the room index page after successfully creating the post
        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
    }

    // Render the new post form with the associated room
    return $this->render('post/new.html.twig', [
        'post' => $post,
        'room' => $room,
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
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager, RoomRepository $roomRepository, int $room_id): Response
    {
        // Fetch the room associated with the post
        $room = $post->getRoom();
    
        // Create the form with the specific room associated with the post
        $form = $this->createForm(PostType::class, $post, [
            'room' => $room,
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
                     return $this->redirectToRoute('app_post_edit', ['id' => $post->getId()]);
                 }
                }
    
            $entityManager->flush();
            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }
    
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
        $room = $post->getRoom();

        return $this->redirectToRoute('app_room_index', ['room' => $room,], Response::HTTP_SEE_OTHER);
    }


}
