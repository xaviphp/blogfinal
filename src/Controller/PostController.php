<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tag;
use App\Form\CommentType;
use App\Form\PostType;
use App\Form\EditPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Entity\User;


class PostController extends AbstractController
{

    /**
     * @Route("/post", name="app_posts")
     */
    public function allPost(){

        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(array('user'=> $this->getUser()));
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/new", name="new_post")
     */
    public function newPost(Request $request)
    {
        //Creau nuevo objeto Post
        $post= new Post();
        $post-> setTitle('write a post title');

        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        $post->setAuthor($user->getUsername());
        $post->setCreatedAt(new \DateTime());
        $post->setPublishedAt(null);

        //Crear formulario
        $form=$this->createForm(PostType::class, $post);

        //handle the request
        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //Capturar los datos
            $post->setUser($this->getUser());
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'Post created'
            );
            //Fluir hacia la base de datos
            return $this->redirectToRoute('app_homepage');

        }

        //render the form
        return $this->render('post/post.html.twig', [
            'error'=>$error,
            'form' => $form->createView()]);
    }

    /**
     * @Route("post/{id}/delete", name="app_post_delete")
     */
    public function deletePost($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('app_posts');


    }

    /**
     * @Route("post/{id}/edit", name="app_post_edit")
     */
    public function editPost(Request $request, $id)
    {
        $title="Edit";
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        //create the form
        $form = $this->createForm(EditPostType::class, $post);

        $form->handleRequest($request);
        $error = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {

            //handle the entities
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'Post edited'
            );
            return $this->redirectToRoute('app_posts');
        }

        //render the form
        return $this->render('post/edit.html.twig',[
            'error'=>$error,
            'form'=>$form->createView(),
            'title'=>$title
        ]);
    }


    /**
     * @Route("post/{id}/show", name="app_post_show")
     */
    public function showPost(Request $request, $id)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $comentariosAct = $this->getDoctrine()->getRepository(Comment::class)->findBy(array('post'=>$post));
        $comentario = new Comment();
        $form = $this->createForm(CommentType::class, $comentario);

        $form->handleRequest($request);
        $error = $form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            $comentario->setUser($this->getUser());
            $comentario->setPost($post);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comentario);
            $entityManager->flush();
        }

        return $this->render('post/showpost.html.twig', [
            'post' => $post,
            'form'=>$form->createView(),
            'comments' => $comentariosAct

        ]);
    }



}
