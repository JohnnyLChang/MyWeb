<?php
class CloudImages
{
    private $files;
    
    public function UploadLocalToCloudFile($local, $id)
    {
        try {                 
                $files = \Cloudinary\Uploader::upload($local, array("public_id" => $id));                
                return $this->Response(1, $files['public_id'], $files['secure_url']);
        } catch (Exception $e) {
            error_log("[UploadToCloudFile]" . $e);
            return $this->Response(0, $e);
        }
    }

    private function Response($success,$result, $url)
    {
        if($success==0){ $result=$result->getMessage(); } 
        return array("success" => $success, "data" => $result, "surl" => $url);
    }
}
?>