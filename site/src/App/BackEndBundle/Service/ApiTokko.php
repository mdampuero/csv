<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Service;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManager;

/**
 * Class ApiTokko
 *
 * @package App\BackEndBundle\Service
 */
class ApiTokko
{
    protected $em;
    protected $setting;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->setting=$this->em->getRepository('AppBackEndBundle:Setting')->find('setting');
    }

    /**
     * @return array
     */
    public function development($development_id=null,$limit=30,$offset=0){
        $params="&limit=".$limit."&offset=".$offset;
        $response = HttpClient::create()->request('GET', $this->setting->getTokkoUrl().'development?key='.$this->setting->getTokkoKey().'&format=json&lang=es_ar'.$params);
        if($response->getStatusCode()!=200)
            return false;
        return json_decode($response->getContent());
    }
    
    /**
     * @return array
     */
    public function property($development_id=null,$limit=30,$offset=0){
        $params="&limit=".$limit."&offset=".$offset;
        if($development_id)
            $params.="&development__id=".$development_id;
        $response = HttpClient::create()->request('GET', $this->setting->getTokkoUrl().'property?key='.$this->setting->getTokkoKey().'&format=json&lang=es_ar'.$params);
        if($response->getStatusCode()!=200)
            return false;
        return json_decode($response->getContent());
    }
    
    /**
     * @return array
     */
    public function propertyGet($propertyId=0){
        $response = HttpClient::create()->request('GET', $this->setting->getTokkoUrl().'property/'.$propertyId.'?key='.$this->setting->getTokkoKey().'&format=json&lang=es_ar');
        $result=[
            'code'=>$response->getStatusCode(),
            'data'=>null
        ];
        if($response->getStatusCode()==200)
            $result['data']=json_decode($response->getContent(),true);
        return $result;
    }
    
    /**
     * @return array
     */
    public function propertyGetBy($params=array()){
        $parameters='';
        foreach($params as $key=>$param){
            $parameters.='&'.$key.'='.$param;
        }
        $response = HttpClient::create()->request('GET', $this->setting->getTokkoUrl().'property/?key='.$this->setting->getTokkoKey().'&format=json&lang=es_ar'.$parameters);
        $result=[
            'code'=>$response->getStatusCode(),
            'data'=>null
        ];
        if($response->getStatusCode()==200){
            $results=json_decode($response->getContent(),true);
            if($results["meta"]["total_count"]>0){
                $properties=[];
                foreach($results["objects"] as $key =>$property){
                    $properties[]=$this->translateCurrency($property);
                }
                $results["objects"]=$properties;
            }
            $result['data']=$results;
        }
        return $result;
    }
    
    public function translateCurrency($property){
        foreach($property["operations"] as $keyOperation => $operation)
            foreach($operation["prices"] as $keyPrices => $price)
                $property["operations"][$keyOperation]["prices"][$keyPrices]["entity"]=current($this->em->getRepository('AppBackEndBundle:Currency')
                    ->getAll()
                    ->andWhere("e.code = :code")->setParameter('code',$price["currency"])
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getArrayResult()
                );
        return $property;
    }

    /**
     * @return array
     */
    public function propertyGetAll($params=array()){
        $parameters='';
        foreach($params as $key=>$param){
            $parameters.='&'.$key.'='.$param;
        }
        $response = HttpClient::create()->request('GET', $this->setting->getTokkoUrl().'property/?key='.$this->setting->getTokkoKey().'&format=json&lang=es_ar'.$parameters);
        $result=[
            'code'=>$response->getStatusCode(),
            'data'=>null
        ];
        if($response->getStatusCode()==200){
            $results=json_decode($response->getContent(),true);
            $result['data']=$results["objects"];
        }
        return $result;
    }
}