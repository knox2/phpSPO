<?php

namespace Office365;

use Office365\Runtime\Auth\ClientCredential;
use Office365\SharePoint\ClientContext;
use Office365\SharePoint\Taxonomy\TaxonomyService;
use Office365\SharePoint\Taxonomy\TermGroup;
use Office365\SharePoint\Taxonomy\TermSet;
use PHPUnit\Framework\TestCase;


class TaxonomyTest extends SharePointTestCase
{

    /**
     * @var TaxonomyService
     */
    protected static $taxSvc;

    public static function setUpBeforeClass(): void
    {
        $settings = include(__DIR__ . '/../Settings.php');
        $appPrincipal = new ClientCredential($settings['ClientId'],$settings['ClientSecret']);
        $appCtx = (new ClientContext($settings['Url']))->withCredentials($appPrincipal);
        self::$taxSvc = $appCtx->getTaxonomy();
        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
    }

    /*public function testLoadClient(){
        self::$taxSvc->executeQuery();
    }*/

    /*public function testGetTermStore()
    {
        $ts = self::$taxSvc->getTermStore()->get()->executeQuery();
        $this->assertNotNull($ts->getResourcePath());
    }*/

    public function testListTermGroups()
    {
        $ts = self::$taxSvc->getTermStore();
        $groups = $ts->getTermGroups()->get()->executeQuery();
        $this->assertNotNull($groups->getResourcePath());
        $returnGroup = $groups->findFirst("name","Geography");
        $this->assertNotNull($returnGroup->getResourcePath());
        return $returnGroup;
    }

    /**
     * @depends testListTermGroups
     * @param TermGroup $targetGroup
     * @return Runtime\ClientObject
     * @throws \Exception
     */
    public function testListTermSets($targetGroup)
    {
        $termSets = $targetGroup->getTermSets()->get()->executeQuery();
        $this->assertNotNull($termSets->getResourcePath());
        $this->assertGreaterThan(0,$termSets->getCount());
        return $termSets->getItem(0);
    }


    /**
     * @depends testListTermSets
     * @param TermSet $targetSet
     */
    public function testListTerms($targetSet)
    {
        $terms = $targetSet->getTerms()->get()->executeQuery();
        $this->assertNotNull($terms->getResourcePath());
    }
}
