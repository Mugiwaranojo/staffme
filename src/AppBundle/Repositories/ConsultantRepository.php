<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;

class ConsultantRepository extends EntityRepository
{
   
    public function findAllTags(){
        $result= array();
        $allConsultant= $this->findAll();
        foreach($allConsultant as $consultant){
            $this->addValueToArray($consultant->getFunctionTitle(), $result);
            $this->addValueToArray($consultant->getMainTag(), $result);
            $this->addValueToArray($consultant->getTechnicalTag(), $result);
            $this->addValueToArray($consultant->getFunctionalTag(), $result);
            $this->addValueToArray($consultant->getNewTag(), $result);
            $this->addValueToArray($consultant->getActivityArea(), $result);
            $this->addValueToArray($consultant->getClient(), $result);
            $this->addValueToArray($consultant->getWishes(), $result);
        }
        return $result;
    }
    
    public function findByAvailability($params){
        $qb = $this->createQueryBuilder("c");
        $qb->Where("1=1");
        $this->buildKeywordsFilter($qb, $params);
        $this->buildSkillsLevelFilter($qb, $params);
        $consultants_list = $qb->getQuery()->getResult();
        $consultantsSortlist = $this->sortByAvailabilityAsc($consultants_list);
        $consultantsFilterList= $this->filterByWeeksRemaining($consultantsSortlist, $params["rangeAvailability-a"],  $params["rangeAvailability-b"]);
        $result= array();
        foreach($consultantsFilterList as $consultant){
            $keywords = array_map("trim", explode(",", $params["inputKeywords"]));
            $result[]= $consultant->addSearchHighlight($keywords);
        }
        return  $result;
    }
    
    private function addValueToArray($value, &$array){
        if(!empty($value)){
            if(is_string($value) && !in_array(strtoupper($value), $array)){
                $array[]=strtoupper($value);
            }else if(is_array ($value)){
                foreach ($value as $val){
                    if(!in_array(strtoupper($val), $array)){
                        $array[]=  strtoupper($val);
                    }
                }
            }
        }
    }
    
    private function buildKeywordsFilter($qb, $data){
        if(!empty($data["inputKeywords"])){
            $andModule =  $qb->expr()->andX();
            $keywords = array_map("trim", explode(",", $data["inputKeywords"]));
            foreach ($keywords as $key=>$keyword){
                $orModule = $qb->expr()->orx();
                $orModule->add($qb->expr()->like('UPPER(c.mainTag)',':word'.$key));
                $orModule->add($qb->expr()->like('UPPER(c.technicalTag)',':word'.$key));
                $orModule->add($qb->expr()->like('UPPER(c.functionalTag)',':word'.$key));
                $orModule->add($qb->expr()->like('UPPER(c.newTag)',':word'.$key));
                $orModule->add($qb->expr()->like('UPPER(c.activityArea)',':word'.$key));
                $orModule->add($qb->expr()->like('UPPER(c.wishes)',':word'.$key));
                $orModule->add($qb->expr()->like('UPPER(c.client)',':word'.$key));
                $orModule->add($qb->expr()->like('UPPER(c.functionTitle)',':word'.$key));
                $qb->setParameter('word'.$key, "%".strtoupper($keyword)."%");
                $andModule->add($orModule);
            }
            $qb->andWhere($andModule);
        }
    }
    
    private function buildFunctionsFilter($qb, $data){
        if(!empty($data["inputFunctions"])){
            $orModule = $qb->expr()->orx();
            $functions = array_map("trim", explode(",", $data["inputFunctions"]));
            foreach ($functions as $key=>$function){
                $orModule->add($qb->expr()->like('UPPER(c.functionTitle)',':title'.$key));
                $qb->setParameter('title'.$key, "%".strtoupper($function)."%");
            }
            $qb->andWhere($orModule);
        }
    }
    
   
    
    private function buildISUFilter($qb, $data){
        if(!empty($data["isu-choice"])){
            $orModule = $qb->expr()->orx();
            foreach ($data["isu-choice"] as $key=>$isu){
                $orModule->add($qb->expr()->like('UPPER(c.isu)',':isu'.$key));
                $qb->setParameter('isu'.$key, "%".strtoupper($level)."%");
            }
            $qb->andWhere($orModule);
        }
    }
    
    private function buildSkillsLevelFilter($qb, $data){
        if(!empty($data["exp-choice"])){
            $orModule = $qb->expr()->orx();
            foreach ($data["exp-choice"] as $key=>$level){
                $orModule->add($qb->expr()->like('UPPER(c.skillsLevel)',':level'.$key));
                $qb->setParameter('level'.$key, "%".strtoupper($level)."%");
            }
            $qb->andWhere($orModule);
        }
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
