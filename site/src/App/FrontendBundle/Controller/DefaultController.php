<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright. All rights reserved.
//

namespace App\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller{
    
    public function indexAction(){
        header('Location: https://rocheapps.orquideatech.com/api/doc');
        return $this->render('AppFrontendBundle:Default:index.html.twig');
    }
}
