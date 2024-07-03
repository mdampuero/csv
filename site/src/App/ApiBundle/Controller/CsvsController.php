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

    /**
     *
     * @ApiDoc(
     *     section="CSVs",
     *     description="Retrieves data from CSV entities.",
     *     parameters={
     *         {"name"="start", "dataType"="integer", "required"=false, "description"="Offset for pagination."},
     *         {"name"="length", "dataType"="integer", "required"=false, "description"="Number of records per page."},
     *         {"name"="query", "dataType"="string", "required"=false, "description"="Search query."},
     *         {"name"="sort", "dataType"="string", "required"=false, "description"="Field to sort by."},
     *         {"name"="direction", "dataType"="string", "required"=false, "description"="Sort direction ('asc' or 'desc')."}
     *     },
     *     headers={
     *         {"name"="Authorization", "description"="JWT token obtained from login endpoint", "required"=true}
     *     },
     *     statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the parameters are invalid",
     *         500="Returned when an unexpected error occurs"
     *     },
     *     tags={"private"},
     *     response={
     *         "data"={"csv"}
     *     },
     *     resource=true
     * )
     *
     * @param Request $request
     * @return Response
     */
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
     *     description="Upload a CSV file using form-data",
     *     parameters={
     *         {"name"="file", "dataType"="file", "required"=true, "description"="Valid CSV file"}
     *     },
     *     statusCodes={
     *         200="File uploaded successfully",
     *         400="Bad Request",
     *         500="Internal Server error",
     *     },
     *     tags={"private"},
     *     headers={
     *         {"name"="Authorization", "description"="JWT token obtained from login endpoint", "required"=true}
     *     }
     * )
     */
    public function postAction(Request $request, LoggerInterface $logger)
    {
        $this->logger->info('REQUEST POST CSV');
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
                $logger->info('FILE UPLOAD',['originalName'=>$entity->getFile(),'fileName'=>$fileName]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->handleView($this->view($entity, Response::HTTP_OK));
            } catch (FileException $e) {
                $logger->error('Error upload: '.$e->getMessage());
                return $this->handleView($this->view($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR));
            }
        }
        $logger->warning('REQUEST FAIL',[$form->getErrors()]);
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