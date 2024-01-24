<?php

namespace Office365;

use DateTime;
use Office365\Runtime\Auth\UserCredentials;
use Office365\SharePoint\File;
use Office365\SharePoint\ListTemplateType;
use Office365\SharePoint\SPList;
use Office365\SharePoint\SPResourcePath;
use Office365\SharePoint\Web;

class FileTest extends SharePointTestCase
{
    /**
     * @var SPList
     */
    private static $targetList;


    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $listTitle = "Documents_" . rand(1, 100000);
        self::$targetList = self::ensureList(self::$context->getWeb(), $listTitle, ListTemplateType::DocumentLibrary);
    }

    public static function tearDownAfterClass(): void
    {
        self::$targetList->deleteObject()->executeQuery();
        parent::tearDownAfterClass();
    }


    public function testGetFileFromAbsUrl(){
        $pageAbsUrl = self::$settings["Url"] . "/sites/team/SitePages/Home.aspx";
        $credentials = new UserCredentials(self::$settings['UserName'],self::$settings['Password']);
        $file = File::fromUrl($pageAbsUrl)->withCredentials($credentials)->get()->executeQuery();
        self::assertNotEmpty($file->getName());
    }


    public function testDownloadFileFromAbsUrl(){
        $pageAbsUrl = self::$settings["Url"] . "/sites/team/SitePages/Home.aspx";
        $credentials = new UserCredentials(self::$settings['UserName'],self::$settings['Password']);

        $fileName = join(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), "Home.aspx"]);
        $fh = fopen($fileName, 'w+');
        File::fromUrl($pageAbsUrl)->withCredentials($credentials)->download($fh)->executeQuery();
        fclose($fh);
        self::assertGreaterThan(0, filesize($fileName));
    }


    public function testUploadFiles(){
        $localPath = __DIR__ . "/../../examples/data/";
        $searchPrefix = $localPath . '*.*';
        $results = [];
        foreach(glob($searchPrefix) as $filename) {
            $uploadFile = self::$targetList->getRootFolder()->uploadFile(basename($filename),file_get_contents($filename));
            self::$context->executeQuery();
            $this->assertNotNull($uploadFile->getLinkingUrl());
            $results[] = $uploadFile;
        }
        $this->assertTrue(true);
        return $results[0];
    }

    /**
     * @depends testUploadFiles
     * @param File $file
     */
    public function testGetFileByResourcePath($file)
    {
        $fileUrl = $file->getServerRelativeUrl();
        $targetFile = self::$context->getWeb()->getFileByServerRelativePath(new SPResourcePath($fileUrl));
        self::$context->load($targetFile);
        self::$context->executeQuery();
        self::assertNotNull($targetFile->getName());
    }

    /**
     * @depends testUploadFiles
     * @param File $file
     */
    public function testAssignFilePermissions($file)
    {
        $fileItem = $file->getListItemAllFields();
        $fileItem->breakRoleInheritance(true);
        self::$context->executeQuery();
        self::$context->load($fileItem,array("HasUniqueRoleAssignments"));
        self::$context->executeQuery();
        self::assertTrue($fileItem->getHasUniqueRoleAssignments());
    }


    /**
     * @depends testUploadFiles
     * @param File $file
     */
    public function testGetFileVersions($file)
    {
        self::$context->load($file,array("Versions"));
        self::$context->executeQuery();
        self::assertNotNull($file->getVersions());
    }

    public function testUploadLargeFile()
    {
        $localPath = __DIR__ . "/../../examples/data/big_buck_bunny.mp4";
        $targetFileName = "large_" . basename($localPath);
        $session = self::$targetList->getRootFolder()->getFiles()->createUploadSession($localPath, $targetFileName,
            function ($uploadedBytes) {
                self::assertNotNull($uploadedBytes);
            });
        self::$context->executeQuery();
        $uploadFile = $session->getFile();
        self::assertNotNull($uploadFile->getName());
    }

    /**
     * @depends testUploadFiles
     * @param File $uploadFile
     */
    public function testUploadedFileCreateAnonymousLink(File $uploadFile)
    {
        $listItem = $uploadFile->getListItemAllFields();
        self::$context->load($listItem,array("EncodedAbsUrl"));
        self::$context->executeQuery();

        $fileUrl = $listItem->getProperty("EncodedAbsUrl");
        $result = Web::createAnonymousLink(self::$context,$fileUrl,false);
        self::$context->executeQuery();
        self::assertNotEmpty($result->getValue());

        $expireDate = new DateTime('now +1 day');
        $result = Web::createAnonymousLinkWithExpiration(self::$context,$fileUrl,false,$expireDate->format(DateTime::ATOM));
        self::$context->executeQuery();
        self::assertNotEmpty($result->getValue());
    }

    /**
     * @depends testUploadFiles
     * @param $fileToMove
     */
    /*public  function testMoveFile(File $fileToMove){
        //$targetUrl = self::$targetList->getRootFolder()->getServerRelativeUrl() . "big_buck_bunny.mp4";
        //$fileToMove->moveToEx("",true);
    }*/


    /**
     * @depends testUploadFiles
     * @param File $fileToDelete
     * @throws \Exception
     */
    public function testDeleteFile(File $fileToDelete)
    {
        $fileName = $fileToDelete->getProperty("Name");
        $fileToDelete->deleteObject()->executeQuery();


        $filesResult = self::$targetList->getRootFolder()->getFiles()->filter("Name eq '$fileName'");
        self::$context->load($filesResult);
        self::$context->executeQuery();
        $this->assertEquals(0,$filesResult->getCount());
    }

}
