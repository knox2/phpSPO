<?php

/**
 * This file was generated by phpSPO model generator 2019-11-17T17:00:44+00:00 16.0.19506.12022
 */
namespace Office365\SharePoint;

use Office365\Runtime\ClientObject;
use Office365\Runtime\ResourcePath;
/**
 * Specifies 
 * the request context information for a site collection when 
 * a SharePoint 
 * Add-in accesses that site collection.
 */
class AppContextSite extends ClientObject
{
    /**
     * @return Site
     */
    public function getSite()
    {
        if (!$this->isPropertyAvailable("Site")) {
            $this->setProperty("Site", new Site($this->getContext(),
                new ResourcePath("Site", $this->getResourcePath())));
        }
        return $this->getProperty("Site");
    }
    /**
     * @return Web
     */
    public function getWeb()
    {
        if (!$this->isPropertyAvailable("Web")) {
            $this->setProperty("Web", new Web($this->getContext(),
                new ResourcePath("Web", $this->getResourcePath())));
        }
        return $this->getProperty("Web");
    }
}
