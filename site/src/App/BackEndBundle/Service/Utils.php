<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class Utils
 *
 * @package App\BackEndBundle\Service
 */
class Utils
{

    /**
     * @return array
     */
    public function clearDeleted($data = array())
    {

        foreach ($data as $key => $item) {
            if ($item->getIsDelete())
                unset($data[$key]);
        }
        return $data;
    }

    public function slugify($string, $replacement = '_')
    {
        $aux = preg_quote($replacement, '/');
        $map = array('/à|á|ã|â/' => 'a', '/è|é|ê|ẽ|ë/' => 'e', '/ì|í|î/' => 'i', '/ò|ó|ô|õ|ø/' => 'o', '/ù|ú|ũ|û/' => 'u', '/ç/' => 'c', '/ñ/' => 'n', '/ä|æ/' => 'ae', '/ö/' => 'oe', '/ü/' => 'ue', '/Ä/' => 'Ae', '/Ü/' => 'Ue', '/Ö/' => 'Oe', '/ß/' => 'ss', '/[^\w\s]/' => ' ', '/\\s+/' => $replacement);
        return preg_replace(array_keys($map), array_values($map), $string);
    }
}