<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use BibliBundle\Entity\Book;
use BibliBundle\Form\BookType;

class BookController extends Controller
{
    public function indexAction($page)
    {
        if($page<1){

           $page++;

          return $this->redirectToRoute('bibli_homepage',array('page' => $page));
        }

        $em =$this->getDoctrine()->getRepository('BibliBundle:Book');
        $books=$em->findAll();

        // Et modifiez le 2nd argument pour injecter notre liste
        return $this->render('BibliBundle:Book:index.html.twig', array(
            'books' => $books
        ));

    }

    public function viewAction(Book $book)
    {
        return $this->render('BibliBundle:Book:view.html.twig', array('book' => $book));
    }

    public function addAction(Request $request)
    {
        $book = new Book();
        $form = $this->get('form.factory')->create(new BookType, $book);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($book);

            $em->flush();

            $request->getSession()->getFlashBag()->add('Info', 'Livre bien enregistrée.');


            return $this->redirectToRoute('bibli_homepage');

       }

        // Si on n'est pas en POST, alors on affiche le formulaire
        return $this->render('BibliBundle:Book:add.html.twig', array('form' => $form->createview()));

    }


    public function editAction(Book $book, Request $request)
    {

        $form = $this->get('form.factory')->create(new BookType, $book);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $a = $form->getData();
            $em->persist($a);

            $em->flush();

            $request->getSession()->getFlashBag()->add('Info', 'Livre bien enregistrée.');


            return $this->redirectToRoute('bibli_homepage');

        }

        // Si on n'est pas en POST, alors on affiche le formulaire
        return $this->render('BibliBundle:Book:edit.html.twig', array('form' => $form->createview()  ));

    }

        public function deleteAction(Book $book)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($book);
        $em->flush();

        return $this->redirect($this->generateUrl('bibli_homepage'));
    }


}
