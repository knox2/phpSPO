<?php

/**
 * Generated  2024-06-08T09:12:30+00:00 16.0.24922.12004
 */
namespace Office365\SharePoint\Sharing;

use Office365\Runtime\ClientValue;
/**
 * This class 
 * is returned when 
 * Microsoft.SharePoint.Client.Sharing.SecurableObjectExtensions.GetSharingInformation 
 * is called with the optional expand on permissionsInformation property. It 
 * contains a collection of LinkInfo and PrincipalInfo objects of users/groups 
 * that have access to the list item and also 
 * the site administrators who have implicit access.
 */
class PermissionCollection extends ClientValue
{
    /**
     * @var bool
     */
    public $hasInheritedLinks;
    /**
     * Read/WriteThe List 
     * of tokenized 
     * sharing links with their LinkInfo objects.
     * @var array
     */
    public $links;
    /**
     * Read/WriteThe List 
     * of Principals with their roles on this list item.
     * @var array
     */
    public $principals;
    /**
     * Read/WriteThe List 
     * of Principals who are Site Admins. This property is returned only if the caller 
     * is an Auditor.
     * @var array
     */
    public $siteAdmins;
    /**
     * @var integer
     */
    public $totalNumberOfPrincipals;
}