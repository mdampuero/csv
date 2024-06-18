<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackOfficeBundle\Controller;

use App\BackEndBundle\Entity\Csv;
use App\BackEndBundle\Form\Csv\CsvType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class CsvsController extends Controller
{

    public function indexAction()
    {
        return $this->render(
            'AppBackOfficeBundle:Csvs:index.html.twig',
            array(
                'formDelete' => $this->createFormBuilder()
                    ->setAction($this->generateUrl('api_csvs_delete', array('id' => ':ENTITY_ID')))
                    ->setMethod('DELETE')
                    ->getForm()->createView(),
            )
        );
    }

    public function addAction()
    {
        return $this->render('AppBackOfficeBundle:Csvs:form.html.twig', array('entity' => new Csv()));
    }

    public function editAction($id)
    {
        return $this->render('AppBackOfficeBundle:Csvs:form.html.twig', array('entity' => $this->getDoctrine()->getRepository(Csv::class)->find($id)));
    }

    public function landingAction($id)
    {
        return $this->render('AppBackOfficeBundle:Csvs:landing.html.twig', array('id' => $id));
    }

    public function getAction($id)
    {
        return $this->render('AppBackOfficeBundle:Csvs:_partials/get.html.twig', array('entity' => $this->getDoctrine()->getRepository(Csv::class)->find($id)));
    }

    public function importAction()
    {
        return $this->render(
            'AppBackOfficeBundle:Csvs:import.html.twig',
            array(
                'form' => $this->createForm(
                    ImportType::class,
                    null,
                    array(
                        'method' => 'POST',
                        'action' => $this->generateUrl('api_csvs_import')
                    )
                )->createView()
            )
        );
    }

    public function form($entity)
    {
        $method = 'POST';
        $action = $this->generateUrl('api_csvs_post');
        if ($entity->getId()) {
            $method = 'PUT';
            $action = $this->generateUrl('api_csvs_put', array('id' => $entity->getId()));
        }
        return $this->render(
            'AppBackOfficeBundle:Csvs:_partials/form.html.twig',
            array(
                'entity' => $entity,
                'form' => $this->createForm(
                    CsvType::class,
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
