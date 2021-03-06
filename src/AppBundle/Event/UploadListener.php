<?php
namespace AppBundle\Event;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Consultant;
use Oneup\UploaderBundle\Event\PostPersistEvent ;
use Psr\Log\LoggerInterface;

class UploadListener
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $logger;
    
    public function __construct(ObjectManager $om, LoggerInterface $logger)
    {
        $this->om = $om;
        $this->logger = $logger;
    }


    public function onUpload(PostPersistEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $file= $request->files->all()["files"][0];
        $uploadedFile = $this->renameFile($file, $event->getFile());

        $types = array('text/csv', 'text/plain' /*, 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'*/);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $uploadedFile);
        finfo_close($finfo);
        if(!in_array($fileType, $types)){
                //Handle the excluded filetypes here
                $response['msg'] = "format file is not supported.";
                $response['success'] = false;
                unlink($uploadedFile);
        } else {
            //Manage the uploaded file here
            $response['msg'] = $file->getClientOriginalName()." is uploaded.";
            $datas= $this->readfileCSV($uploadedFile);
            $response['success'] = $this->saveConsultantsCSVDatas($datas);
            if(!$response['success']){
                $response['msg'] = "Error while saving datas.";
            }
        }
    }

    private function renameFile($requestFile, $uploadedFile){
            $filePath= str_replace($uploadedFile->getFileName(), "", $uploadedFile->getPathName());
            $finaleName=$filePath.str_replace(" ", "_", $requestFile->getClientOriginalName());
            rename($uploadedFile->getPathName(),$finaleName);	
            return $finaleName;
    }

    private function readfileCSV($filename){
        $row = 0;
        $dataReturn= array();
        if (($handle = fopen($filename, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 100000, ";")) !== FALSE) {
                        if(empty($data[0])){
                                continue;
                        }
                        $num = count($data);
                        $dataReturn[$row]= array();
                        for ($c=0; $c < $num ; $c++) {
                                $dataReturn[$row][$c]= $data[$c];
                        }
                        $row++;
                }
                fclose($handle);
        }
        return $dataReturn;
    }

    private function saveConsultantsCSVDatas($datas){
        $this->logger->info('saveConsultantsCSVDatas start');
        $this->logger->info('saveConsultantsCSVDatas data length: '.count($datas));
        for($i=1; $i < count($datas); $i++){
            if(isset($datas[$i][3])&&intval($datas[$i][3])!=0){
                $consultantId= intval($datas[$i][3]);
                $consultantRequest = $this->om->getRepository('AppBundle:Consultant')->find($consultantId);
                if (!$consultantRequest){
                        $consultant = new Consultant();
                        $consultant->setId($consultantId);
                        $consultant->setCreated(new \DateTime("now"));
                }else{
                    $consultant= $consultantRequest;
                }
                $this->datasToConsultant($datas[$i], $consultant);
                if(!$consultantRequest){
                    $this->om->persist($consultant);
                    $metadata = $this->om->getClassMetaData(get_class($consultant));
                    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);         
                }
                $this->om->flush();
            }
        }
        return true;
    }

    private function datasToConsultant($data, $consultant){
        $consultant->setLastname($data[1]);
        $consultant->setFirstname($data[2]);
        $consultant->setIsu($data[0]);
        $consultant->setRecruitement($this->convertDateTime($data[4]));
        $consultant->setSeparation($this->convertDateTime($data[5]));
        $consultant->setFunctionTitle($data[12]);
        $consultant->setSkillsLevel($data[6]);
        $consultant->setManager($data[7]);
        $consultant->setPhone(str_replace(" ", "", $data[9]));
        $consultant->setEmail($data[10]);
        $consultant->setMainTag($this->convertTagToJSON($data[13]));
        $consultant->setTechnicalTag($this->convertTagToJSON($data[14]));
        $consultant->setFunctionalTag($this->convertTagToJSON($data[15]));
        $consultant->setNewTag($this->convertTagToJSON($data[16]));
        $consultant->setActivityArea($this->convertTagToJSON($data[18]));
        $consultant->setLanguages($this->convertLanguagesToJSON($data[11]));
        $consultant->setAvailability($this->convertAvailabilityToJSON($data[20]));
        $consultant->setMissionEnd($this->convertDateTime($data[21]));
        $consultant->setMissionExtension(intval($data[22]));
        $consultant->setUpdated(new \DateTime("now"));
        
    }

    private function convertDateTime($value){
        $dateTable= explode("/", $value);
        if(count($dateTable)<3){
                return null;
        }
        return new \DateTime($dateTable[2]."-".$dateTable[1]."-".$dateTable[0]);
    }
    
    private function convertTagToJSON($value){
        if(empty($value)){
            return null;
        }
        return array_map("trim", explode(",", $value));
    }
    
    private function convertAvailabilityToJSON($value){
        if(empty($value)){
            return null;
        }
        if(preg_match('/\s*(?P<value>\d+),\s*(?P<complement>[a-zA-Z0-9\/\s]+)/', $value, $matches)){
            if(isset($matches["complement"])){
                return array("value"=> intval($matches["value"]),
                              "complement"=>$matches["complement"]);
            }else{
                return array("value"=>intval($matches["value"]),
                              "complement"=>null);
            }
        }else{
            return null;
        }
    }
    
    
    private function convertLanguagesToJSON($value){
        $result= array();
        $result["English"]= $value;
        return $result;
    }
}
?>