<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\BackEndBundle\Entity\Csv;
use App\BackEndBundle\Form\Csv\CsvType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Psr\Log\LoggerInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CsvsController extends BaseController
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function indexAction(Request $request)
    {
        $offset = $request->query->get('start', 0);
        $query = $request->query->get('query');
        $limit = $request->query->get('length', 30);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);
        return $this->handleView(
            $this->view(
                array(
                    'data' => $this->getDoctrine()->getRepository(Csv::class)->search($query, $limit, $offset, $sort, $direction, [])->getQuery()->getResult(),
                    'recordsTotal' => $this->getDoctrine()->getRepository(Csv::class)->total(),
                    'recordsFiltered' => $this->getDoctrine()->getRepository(Csv::class)->searchTotal($query, $limit, $offset, null, null, []),
                    'offset' => $offset,
                    'limit' => $limit,
                )
            )
        );
    }

    public function getAction($id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(Csv::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        return $this->handleView($this->view($entity));
    }

    /**
     *
     * @ApiDoc(
     *     section="CSVs",
     *     description="Sube un archivo CSV utilizando form-data.",
     *     parameters={
     *         {"name"="file", "dataType"="file", "required"=true, "description"="Archivo CSV a subir"}
     *     },
     *     statusCodes={
     *         200="Archivo CSV subido correctamente",
     *         400="Error en la solicitud",
     *         500="Error interno",
     *     }
     * )
     */
    public function postAction(Request $request, LoggerInterface $logger)
    {
        $entity = new Csv();
        $form = $this->createForm(CsvType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $entity->getFile();
            $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            try {
                $file->move($this->getParameter('csv_directory'),$fileName);
                $entity->setFile($fileName);
                $entity->setOriginalName($file->getClientOriginalName());
                
                $logger->info('File upload',['originalName'=>$entity->getFile(),'fileName'=>$fileName]);

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->handleView($this->view($entity, Response::HTTP_OK));
            } catch (FileException $e) {
                $logger->error('Error upload: '.$e->getMessage());
                return $this->handleView($this->view($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR));
            }
        }
        $logger->warning('BAD_REQUEST',[$form->getErrors()]);
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }
    
    public function deleteAction(Request $request, $id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(Csv::class)->find($id))
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