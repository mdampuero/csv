<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class ApiCall
 *
 * @package App\BackEndBundle\Service
 */
class ApiCall
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function post($endpoint, $data = array())
    {
        $ch = curl_init($endpoint);
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (!curl_errno($ch))
            $return = array('code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), 'result' => json_decode($result, TRUE));
        else
            $return = array('code' => curl_errno($ch), 'result' => curl_error($ch));
        curl_close($ch);
        return $return;
    }

    /**
     * @return array
     */
    public function get($endpoint)
    {
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (!curl_errno($ch))
            $return = array('code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), 'result' => json_decode($result, TRUE));
        curl_close($ch);
        return $return;
    }

}