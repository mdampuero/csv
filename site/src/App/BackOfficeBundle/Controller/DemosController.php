<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackOfficeBundle\Controller;

use App\BackEndBundle\Entity\Demo;
use App\BackEndBundle\Form\Demo\DemoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class DemosController extends Controller
{

    public function indexAction()
    {
        return $this->render(
            'AppBackOfficeBundle:Demos:index.html.twig',
            array(
                'formDelete' => $this->createFormBuilder()
                    ->setAction($this->generateUrl('api_demos_delete', array('id' => ':ENTITY_ID')))
                    ->setMethod('DELETE')
                    ->getForm()->createView(),
            )
        );
    }

    public function addAction()
    {
        return $this->render('AppBackOfficeBundle:Demos:form.html.twig', array('entity' => new Demo()));
    }

    public function editAction($id)
    {
        return $this->render('AppBackOfficeBundle:Demos:form.html.twig', array('entity' => $this->getDoctrine()->getRepository(Demo::class)->find($id)));
    }

    public function landingAction($id)
    {
        return $this->render('AppBackOfficeBundle:Demos:landing.html.twig', array('id' => $id));
    }

    public function getAction($id)
    {
        return $this->render('AppBackOfficeBundle:Demos:_partials/get.html.twig', array('entity' => $this->getDoctrine()->getRepository(Demo::class)->find($id)));
    }

    public function importAction()
    {
        return $this->render(
            'AppBackOfficeBundle:Demos:import.html.twig',
            array(
                'form' => $this->createForm(
                    ImportType::class,
                    null,
                    array(
                        'method' => 'POST',
                        'action' => $this->generateUrl('api_demos_import')
                    )
                )->createView()
            )
        );
    }

    public function form($entity)
    {
        $method = 'POST';
        $action = $this->generateUrl('api_demos_post');
        if ($entity->getId()) {
            $method = 'PUT';
            $action = $this->generateUrl('api_demos_put', array('id' => $entity->getId()));
        }
        return $this->render(
            'AppBackOfficeBundle:Demos:_partials/form.html.twig',
            array(
                'entity' => $entity,
                'form' => $this->createForm(
                    DemoType::class,
                    $entity,
                    array(
                        'method' => $method,
                        'action' => $action
                    )
                )->createView()
            )
        );
    }
}
