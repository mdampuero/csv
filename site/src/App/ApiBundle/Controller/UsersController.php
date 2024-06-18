<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\BackEndBundle\Entity\User;
use App\BackEndBundle\Form\User\UserAddType;
use App\BackEndBundle\Form\User\UserType;
use App\BackEndBundle\Form\User\ProfileType;
use App\BackEndBundle\Form\User\UserAttributeType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends BaseController
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
                'data' => $this->getDoctrine()->getRepository(User::class)->search($query, $limit, $offset, $sort, $direction)->getQuery()->getResult(),
                'recordsTotal' => $this->getDoctrine()->getRepository(User::class)->total(),
                'recordsFiltered' => $this->getDoctrine()->getRepository(User::class)->searchTotal($query, $limit, $offset),
                'offset' => $offset,
                'limit' => $limit,
            )
        ));
    }

    public function getAction($id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(User::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        return $this->handleView($this->view($entity));
    }

    public function postAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entity = new User();
        $form = $this->createForm(UserAddType::class, $entity);
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('pictureBase64')->getData())
                $entity->setPicture($this->base64ToFile($form->get('pictureBase64')->getData(), "uploads/"));
            $password = $passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
            $entity->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function putAction(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (!$entity = $this->getDoctrine()->getRepository(User::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $form = $this->createForm(UserType::class, $entity);
        $pictureOld = $entity->getPicture();
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('pictureBase64')->getData())
                $entity->setPicture($this->base64ToFile($form->get('pictureBase64')->getData(), "uploads/"));
            else {
                if ($form->get('pictureRemove')->getData())
                    $pictureOld = null;
                $entity->setPicture($pictureOld);
            }
            if (!empty($form->get('plainPassword')->getData())) {
                $password = $passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
                $entity->setPassword($password);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function putAttributeAction(Request $request, $id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(User::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $form = $this->createForm(UserAttributeType::class, $entity);
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function profileAction(Request $request, $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (!$entity = $this->getDoctrine()->getRepository(User::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $form = $this->createForm(ProfileType::class, $entity);
        $pictureOld = $entity->getPicture();
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('pictureBase64')->getData())
                $entity->setPicture($this->base64ToFile($form->get('pictureBase64')->getData(), "uploads/"));
            else {
                if ($form->get('pictureRemove')->getData())
                    $pictureOld = null;
                $entity->setPicture($pictureOld);
            }
            if (!empty($form->get('plainPassword')->getData())) {
                $password = $passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
                $entity->setPassword($password);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function deleteAction(Request $request, $id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(User::class)->find($id))
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