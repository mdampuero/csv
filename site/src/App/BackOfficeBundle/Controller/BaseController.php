<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackOfficeBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    // public function getStructure($days,$rooms){
    //     $blocks=[];
    //     foreach($days as $key => $day){
    //         foreach($rooms as $room){
    //             if($room->getIsDelete()) continue;
    //             $blocks[$key][$room->getId()]["size"]="";
    //             $blocks[$key][$room->getId()]["cost_price"]="";
    //             $blocks[$key][$room->getId()]["sale_price"]="";
    //             $blocks[$key][$room->getId()]["tax_percent"]="";
    //             $blocks[$key][$room->getId()]["tax_value"]="";
    //         }
    //     }
    //     return $blocks;
    // }
}