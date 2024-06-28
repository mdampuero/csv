<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright. All rights reserved.
//

namespace App\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller{
    
    public function indexAction(){
        return $this->redirectToRoute('app_backoffice_homepage');
        return $this->render('AppFrontendBundle:Default:index.html.twig');
    }
}
