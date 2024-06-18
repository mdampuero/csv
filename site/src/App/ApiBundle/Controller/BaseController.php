<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\ApiBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use FOS\RestBundle\Controller\FOSRestController;
use App\BackEndBundle\Entity\Gallery;

class BaseController extends FOSRestController
{

    protected $setting = array(
        'uploads_directory' => 'uploads/or/',
        'resize' => array(
            'xs' => array(
                'width' => 120,
                'height' => 120,
                'path' => 'uploads/xs/',
            ),
            'sm' => array(
                'width' => 240,
                'height' => null,
                'path' => 'uploads/sm/',
            ),
            'md' => array(
                'width' => 480,
                'height' => null,
                'path' => 'uploads/md/',
            ),
            'lg' => array(
                'width' => 800,
                'height' => null,
                'path' => 'uploads/lg/',
            ),
            'xl' => array(
                'width' => 1600,
                'height' => null,
                'path' => 'uploads/xl/',
            )
        )
    );

    public function readCsv($file,$requiredColumns=[]){
        $results=[];
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, null, ';')) !== FALSE) {
                $isFail=0;
                foreach($data as $key => $d){
                    //IS EMPTY
                    if(empty($d) && in_array($key,$requiredColumns)){
                        $isFail=1;
                        $data[$key]="";
                    }
                }
                //if($isFail==1)
                    array_unshift($data, $isFail);
                 
                $results[]=$data;      
            }
            fclose($handle);
        }
        return $results;
    }

    /**
     * @return array
     */
    public function base64ToFile($string)
    {
        $path = $this->setting['uploads_directory'];

        $dataFile = explode("base64,", $string);

        if (!array_key_exists(0, $dataFile))
            throw new Exception('Formato inválido.', 6);
        $dataFileInfo = explode(":", $dataFile[0]);

        if (!array_key_exists(1, $dataFileInfo))
            throw new Exception('Formato inválido.', 6);
        $dataFileExtension = explode("/", $dataFileInfo[1]);

        if (!array_key_exists(1, $dataFileExtension))
            throw new Exception('Formato inválido.', 6);
        $extension = str_replace(";", "", $dataFileExtension[1]);

        if (!array_key_exists(1, $dataFile))
            throw new Exception('Formato inválido.', 6);
        if ($dataFile[1] == 'remove')
            return null;
        $data = base64_decode($dataFile[1]);
        $roughsize = strlen($data);
        // if($roughsize>2097152)
        // 	throw new Exception('La imagen es demasiado grande',6);

        $fileName = md5(uniqid()) . '.' . $extension;
        $success = file_put_contents($path . $fileName, $data);
        if (!$success)
            throw new Exception('No se pudo subir la imagen.', 6);

        $resizes = $this->setting['resize'];
        foreach ($resizes as $resize) {
            $this->get('Image')->smart_resize_image($path . $fileName, $resize['width'], $resize['height'], true, $resize['path'] . $fileName, false, false);
        }
        return $fileName;
    }

    public function displayErrors($field, $message)
    {
        return [
            'form' => [
                'errors' => [
                    'children' => [
                        $field => [
                            'errors' => [$message]
                        ]
                    ]
                ]
            ]
        ];
    }

    public function changeFormatDate(&$content, $inputName,$time=""){
        $dateObject = \DateTime::createFromFormat("d/m/Y H:i:s", $content[$inputName]. $time);
        $content[$inputName]=$dateObject;
    }

    public function validateDateInRange($date,$rangeFrom,$rangeTo){
        // echo '<pre>';
        // print_r($rangeFrom);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($rangeTo);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($date);
        // echo '</pre>';
        // exit();
        if($date < $rangeFrom || $date > $rangeTo){
            return false;
        }
        return true;
    }
}