<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;

class ConsultantRepository extends EntityRepository
{
    
    public function findByAvailability($params){
        $qb = $this->createQueryBuilder("c");
        if(!empty($params["inputKeywords"])){
            $keywords = array_map("trim", explode(",", $params["inputKeywords"]));
            foreach ($keywords as $key=>$keyword){
                if($key==0){
                    $qb->Where('UPPER(c.mainTag) LIKE :word'.$key);
                }else{
                     $qb->orWhere('UPPER(c.mainTag) LIKE :word'.$key);
                }
                $qb->orWhere('UPPER(c.technicalTag) LIKE :word'.$key)
                   ->orWhere('UPPER(c.functionalTag) LIKE :word'.$key)
                   ->orWhere('UPPER(c.newTag) LIKE :word'.$key)
                   ->orWhere('UPPER(c.activityArea) LIKE :word'.$key)
                   ->orWhere('UPPER(c.wishes) LIKE :word'.$key)
                   ->orWhere('UPPER(c.client) LIKE :word'.$key)
                   ->orWhere('UPPER(c.functionTitle) LIKE :word'.$key)
                   ->setParameter('word'.$key, "%".strtoupper($keyword)."%");
            }
        }
        if(!empty($params["inputFunctions"])){
            $functions = array_map("trim", explode(",", $params["inputFunctions"]));
            foreach ($functions as $key=>$function){
                if($key==0 && !empty($params["inputKeywords"])){
                    $qb->andWhere('UPPER(c.functionTitle) LIKE :title'.$key);
                }else if($key==0){
                    $qb->Where('UPPER(c.functionTitle) LIKE :title'.$key);
                }else{
                    $qb->orWhere('UPPER(c.functionTitle) LIKE :title'.$key);
                }
                $qb->setParameter('title'.$key, "%".strtoupper($function)."%");
            }
        }
        //$consultants_list = $this->findBy($searchParams, array('missionEnd' => 'ASC'));
        $consultants_list = $qb->getQuery()->getResult();
        $consultantsSortlist = $this->sortByAvailabilityAsc($consultants_list);
        $consultantsFilterList= $this->filterByWeeksRemaining($consultantsSortlist, $params["rangeAvailability-a"],  $params["rangeAvailability-b"]);
        return $consultantsFilterList;
    }
    
    private function filterByWeeksRemaining($consultantsArray, $min, $max){
        $result=array();
        if($min==0)$min=-1;
        if($max==8)$max=100000;
        foreach ($consultantsArray as $consultant){
            if($consultant->getWeeksRemaining()>=$min && $consultant->getWeeksRemaining()<=$max){
                $result[]=$consultant;
            }
        }
        return $result;
    }
    private function sortByAvailabilityAsc($consultantsArray){
        if($this->isSortByAvailabilityAsc($consultantsArray)){
            return $consultantsArray;
        }else{
             for($i=0; $i < count($consultantsArray)-1 ; $i++){
                if($consultantsArray[$i]->getWeeksRemaining() > $consultantsArray[$i+1]->getWeeksRemaining()){
                    $temp=$consultantsArray[$i];
                    $consultantsArray[$i]= $consultantsArray[$i+1];
                    $consultantsArray[$i+1]= $temp;
                }
            }
            return $this->sortByAvailabilityAsc($consultantsArray);
        }
    }


    private function isSortByAvailabilityAsc($consultantsArray){
        for($i=0; $i < count($consultantsArray)-1 ; $i++){
            if($consultantsArray[$i]->getWeeksRemaining() > $consultantsArray[$i+1]->getWeeksRemaining()){
                return false;
            }
        }
        return true;
    }
    
}
