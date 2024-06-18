<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\BackEndBundle\Entity\Demo;
use App\BackEndBundle\Form\Demo\DemoType;

class DemosController extends BaseController
{

    public function indexAction(Request $request)
    {
        $offset = $request->query->get('start', 0);
        $query = $request->query->get('query');
        $limit = $request->query->get('length', 30);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);
        return $this->handleView($this->view(
            array(
                'data' => $this->getDoctrine()->getRepository(Demo::class)->search($query, $limit, $offset, $sort, $direction, [])->getQuery()->getResult(),
                'recordsTotal' => $this->getDoctrine()->getRepository(Demo::class)->total(),
                'recordsFiltered' => $this->getDoctrine()->getRepository(Demo::class)->searchTotal($query, $limit, $offset, null, null, []),
                'offset' => $offset,
                'limit' => $limit,
            )
        )
        );
    }

    public function getAction($id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(Demo::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        return $this->handleView($this->view($entity));
    }

    public function postAction(Request $request)
    {
        $entity = new Demo();
        $form = $this->createForm(DemoType::class, $entity);
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function importAction(Request $request)
    {
        $form = $this->createForm(ImportType::class, null);
        $content = json_decode($request->getContent(), true);
        $form->submit($content);
        if ($form->isSubmitted() && $form->isValid()) {
            $path = 'uploads/or/';
            $file = $this->get('Base64Service')->convertToFile($content["file"]["base64"], $path);
            try {
                $this->getDoctrine()->getRepository(Demo::class)->import($path . $file);
                return $this->handleView($this->view("", Response::HTTP_OK));
            } catch (\Throwable $th) {
                return $this->handleView($this->view($th->getMessage(), Response::HTTP_BAD_REQUEST));
            }

        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function putAction(Request $request, $id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(Demo::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $form = $this->createForm(DemoType::class, $entity);
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function deleteAction(Request $request, $id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(Demo::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $form = $this->createFormBuilder(null, array('csrf_protection' => false))->setMethod('DELETE')->getForm();
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setIsDelete(true);
            $this->getDoctrine()->getManager()->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

}