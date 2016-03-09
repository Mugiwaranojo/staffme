<?php
namespace AppBundle\Event;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Consultant;
use Oneup\UploaderBundle\Event\PostPersistEvent ;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;


class UploadListener
{
    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
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
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				if(empty($data[0])){
					continue;
				}
				$num = count($data);
				$dataReturn[$row]= array();
				for ($c=0; $c <= 27; $c++) {
					$dataReturn[$row][$c]= $data[$c];
				}
				$row++;
			}
			fclose($handle);
		}
		return $dataReturn;
	}
	
	private function saveConsultantsCSVDatas($datas){
		for($i=1; $i < count($datas); $i++){
			$consultant= $this->datasToConsultant($datas[$i]);
			if(!$this->om->getRepository('AppBundle:Consultant')->find(intval($datas[$i][3]))){
				$this->om->persist($consultant);
				$metadata = $this->om->getClassMetaData(get_class($consultant));
				$metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
			}
			$this->om->flush();
		}
		return true;
	}
	
	private function datasToConsultant($data){
		$consultant = $this->om->getRepository('AppBundle:Consultant')->find(intval($data[3]));
		if (!$consultant) {
			$consultant = new Consultant();
			$consultant->setId(intval($data[3]));
			$consultant->setCreated(new \DateTime("now"));
		}
		$consultant->setLastname($data[1]);
		$consultant->setFirstname($data[2]);
		$consultant->setIsu($data[0]);
		$consultant->setRecruitement($this->convertDateTime($data[4]));
		$consultant->setSeparation($this->convertDateTime($data[5]));
		$consultant->setFunctionTitle($data[13]);
		$consultant->setSkillsLevel($data[6]);
		$consultant->setManager($data[7]);
		$consultant->setPhone($data[9]);
		$consultant->setEmail($data[10]);
		$consultant->setAdresse($data[20]);
		$consultant->setMainTag($data[14]);
		$consultant->setTechnicalTag($data[15]);
		$consultant->setFunctionalTag($data[16]);
		$consultant->setNewTag($data[17]);
		$consultant->setWishes($data[18]);
		$consultant->setlanguages($data[11]);
		$consultant->setTraining($data[19]);
		$consultant->setClient($data[8]);
		$consultant->setAvailability($data[23]);
		$consultant->setMissionStart($this->convertDateTime($data[25]));
		$consultant->setMissionEnd($this->convertDateTime($data[26]));
		$consultant->setMissionExtension(intval($data[27]));
		$consultant->setUpdated(new \DateTime("now"));
		return  $consultant;
	}
	
	private function convertDateTime($value){
		$dateTable= explode("/", $value);
		if(count($dateTable)<3){
			return null;
		}
		return new \DateTime($dateTable[2]."-".$dateTable[1]."-".$dateTable[0]);
	}
}
?>