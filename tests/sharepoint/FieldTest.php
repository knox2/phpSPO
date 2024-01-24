<?php

namespace Office365;

use Office365\SharePoint\Field;
use Office365\SharePoint\FieldCreationInformation;
use Office365\SharePoint\FieldType;
use Office365\SharePoint\ListTemplateType;
use Office365\SharePoint\SPList;


class FieldTest extends SharePointTestCase
{
    /**
     * @var SPList
     */
    private static $targetList;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $listTitle = "Contacts_" . rand(1, 100000);
        self::$targetList = self::ensureList(self::$context->getWeb(), $listTitle, ListTemplateType::Contacts);
    }

    public static function tearDownAfterClass(): void
    {
        self::$targetList->deleteObject()->executeQuery();
        parent::tearDownAfterClass();
    }

    public function testReadSiteColumns()
    {
        $fields = self::$context->getSite()
            ->getRootWeb()
            ->getFields()
            ->get()
            ->executeQuery();
        $this->assertNotEmpty($fields->getCount());
    }


    public function testReadListColumns()
    {
        $fields = self::$targetList->getFields()->get()->executeQuery();
        $this->assertNotEmpty($fields->getCount());
    }


    public function testCreateColumn()
    {
        $fieldProperties = new FieldCreationInformation();
        $fieldProperties->Title =  'Contact location' . rand(1, 100);
        $fieldProperties->FieldTypeKind = FieldType::Geolocation;

        $fields = self::$context->getSite()->getRootWeb()->getFields();
        $field = $fields->add($fieldProperties);
        self::$context->executeQuery();
        $this->assertEquals($field->getProperty('Title'), $fieldProperties->Title);
        return $field;
    }


    /**
     * @depends testCreateColumn
     * @param Field $fieldToDelete
     */
    public function testDeleteColumn(Field $fieldToDelete)
    {
        
        $fieldId = $fieldToDelete->getId();
        $fieldToDelete->deleteObject()->executeQuery();
        
        $result =  self::$context->getSite()->getRootWeb()->getFields()->filter("Id eq '$fieldId'");
        self::$context->load($result);
        self::$context->executeQuery();

        self::assertEquals(0,$result->getCount());
    }


    public function testFindColumn()
    {
        $field = self::$context->getSite()->getRootWeb()->getFields()->getByInternalNameOrTitle("FileRef");
        self::$context->load($field);
        self::$context->executeQuery();
        $this->assertNotNull($field->getTitle());
    }

}
