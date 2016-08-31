﻿### About
The library provides a Office 365 REST client for PHP applications. It allows to performs CRUD operations against SharePoint and Outlook resources via an REST/OData based API. 

#### The list of supported Office 365 REST APIs:

-   SharePoint REST API (_supported_ versions: [SharePoint 2013](https://msdn.microsoft.com/library/office/jj860569(v=office.15).aspx), SharePoint 2016 and SharePoint Online )
-   [Outlook Contacts REST API](https://msdn.microsoft.com/en-us/office/office365/api/contacts-rest-operations)

### Status

[![Build Status](https://travis-ci.org/vgrem/phpSPO.svg?branch=master)](https://travis-ci.org/vgrem/phpSPO)

### Installation

### PHP version
- PHP 5.4 or later


### API

-  PHP:cURL underlying library is used to perform HTTP requests 
-  `ClientContext` - represents a SharePoint client context to performs CRUD operations against SharePoint resources via SharePoint Online REST API
-  `OutlookClient` - represents a client context to performs CRUD operations against Office resources such as Outlook resources
-  `ClientRequest` - represents a client request (more low level compared to `ClientContext`) to to performs CRUD operations against SharePoint resources via SharePoint Online REST API
-  `AuthenticationContext` - represents an object that provides credentials to access SharePoint Online resources.
-  `NetworkCredentialContext` - provides credentials for password-based authentication schemes such as Basic.
  

There are **two** approaches available to perform REST queries:

-   via `ClientRequest` class where you need to construct REST queries by specifying endpoint url, headers if required and payload (low level approach), see [renameFolder.php](https://github.com/vgrem/phpSPO/blob/master/examples/renameFolder.php) for a more details
-   via `ClientContext` class where you target client object resources such as Web, ListItem and etc., see [list_examples.php](https://github.com/vgrem/phpSPO/blob/master/examples/list_examples.php) for a more details 


### Usage


The following examples demonstrates how to perform basic CRUD operations against **SharePoint** list item resources.

Example 1. How to read SharePoint list items

````

$authCtx = new AuthenticationContext($Url);
$authCtx->acquireTokenForUser($UserName,$Password); //authenticate

$ctx = new ClientContext($Url,$authCtx); //initialize REST client    
$web = $ctx->getWeb();
$list = $web->getLists()->getByTitle($listTitle); //init List resource
$items = $list->getItems();  //prepare a query to retrieve from the 
$ctx->load($items);  //save a query to retrieve list items from the server 
$ctx->executeQuery(); //submit query to SharePoint Online REST service
foreach( $items->getData() as $item ) {
    print "Task: '{$item->Title}'\r\n";
}
````


Example 2. How to create SharePoint list item:
````
$listTitle = 'Tasks';
$list = $ctx->getWeb()->getLists()->getByTitle($listTitle);
$itemProperties = array('Title' => 'Order Approval', 'Body' => 'Order approval task','__metadata' => array('type' => 'SP.Data.TasksListItem'));
$item = $list->addItem($itemProperties);
$ctx->executeQuery();
print "Task '{$item->Title}' has been created.\r\n";
````

Example 3. How to delete a SharePoint list item:
````
$listTitle = 'Tasks';
$itemToDeleteId = 1;
$list = $ctx->getWeb()->getLists()->getByTitle($listTitle);
$listItem = $list->getItemById($itemToDeleteId);
$listItem->deleteObject();
$ctx->executeQuery();
````

Example 4. How to update SharePoint list item:
````
$listTitle = 'Tasks';
$itemToUpdateId = 1;
$list = $ctx->getWeb()->getLists()->getByTitle($listTitle);
$listItem = $list->getItemById($itemId);
$itemProperties = array('PercentComplete' => 1);
$listItem->update($itemProperties);
$ctx->executeQuery();
````




## Changelog

1.0.0 - May 23st, 2014
- Initial release.
 
2.0.0 - February 14, 2016
- `AuthenticationContext` and `ClientContext` classes have been introduced.  
