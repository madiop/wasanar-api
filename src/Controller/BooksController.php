<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BooksController extends AbstractController
{
    
    public function index(Request $request)
    {
        $vars = $request->request->all();
        $vars = json_decode($request->getContent(), true);
        // $vars = $request->get('name');

        if($vars){
            // $arr = json_decode($vars, true);
            var_dump($vars);
            echo $vars['name'];
            exit;
        }
        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }
}
