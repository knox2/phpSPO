<?php


require_once '../../vendor/autoload.php';
$settings = include('../../../tests/Settings.php');

use Office365\Runtime\Auth\UserCredentials;
use Office365\SharePoint\ClientContext;


/*function uploadFileAlt(ClientContext $ctx, $sourceFilePath, $targetFileUrl)
{
    $fileContent = file_get_contents($sourceFilePath);
    try {
        Office365\SharePoint\File::saveBinary($ctx, $targetFileUrl, $fileContent);
        print "File has been uploaded\r\n";
    } catch (Exception $e) {
        print "File upload failed:\r\n";
    }
}*/


$credentials = new UserCredentials($settings['UserName'], $settings['Password']);
$ctx = (new ClientContext($settings['Url']))->withCredentials($credentials);
$localPath =  "../../data/";
$targetLibraryTitle = "Documents";
$targetList = $ctx->getWeb()->getLists()->getByTitle($targetLibraryTitle);

$searchPrefix = $localPath . '*.*';
foreach(glob($searchPrefix) as $filename) {
    $uploadFile = $targetList->getRootFolder()->uploadFile(basename($filename),file_get_contents($filename));
    $ctx->executeQuery();
    print "File {$uploadFile->getServerRelativeUrl()} has been uploaded\r\n";
}

