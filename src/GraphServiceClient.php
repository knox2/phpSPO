<?php

namespace Office365;


use Office365\Directory\Applications\Application;
use Office365\Directory\Groups\Group;
use Office365\Directory\Groups\GroupSetting;
use Office365\Directory\Users\User;
use Office365\Directory\Users\UserCollection;
use Office365\OneDrive\DriveItems\DriveItem;
use Office365\OneDrive\Drives\DriveCollection;
use Office365\OneDrive\Sites\Site;
use Office365\Reports\ReportRoot;
use Office365\Runtime\Auth\AADTokenProvider;
use Office365\Runtime\Auth\ClientCredential;
use Office365\Runtime\Auth\UserCredentials;
use Office365\Runtime\ClientRuntimeContext;
use Office365\Runtime\Actions\DeleteEntityQuery;
use Office365\Runtime\Http\HttpMethod;
use Office365\Runtime\OData\V4\JsonFormat;
use Office365\Runtime\OData\ODataMetadataLevel;
use Office365\Runtime\OData\ODataRequest;
use Office365\Runtime\Office365Version;
use Office365\Runtime\ResourcePath;
use Office365\Runtime\Actions\UpdateEntityQuery;
use Office365\Runtime\Http\RequestOptions;
use Office365\Teams\TeamCollection;
use RuntimeException;


/**
 * The Microsoft Graph client is intended to make calls to Microsoft Graph API
 */
class GraphServiceClient extends ClientRuntimeContext
{

    /**
     * Graph Client.
     * @param callable $acquireToken
     */
    public function __construct(callable $acquireToken)
    {
        $this->acquireTokenFunc = $acquireToken;
        $this->getPendingRequest()->beforeExecuteRequest(function (RequestOptions $request) {
            $this->authenticateRequest($request);
            $this->prepareRequest($request);
        });
        parent::__construct();
    }

    /**
     * Initializes a client to acquire a token via user credentials.
     * @param $tenantName
     * @param $clientId
     * @param $userName
     * @param $password
     * @return GraphServiceClient
     */
    public static function withUserCredentials($tenantName, $clientId, $userName, $password)
    {
        return new GraphServiceClient(function () use ($password, $userName, $clientId, $tenantName) {
            $resource = "https://graph.microsoft.com";
            $provider = new AADTokenProvider($tenantName);
            return $provider->acquireTokenForPassword($resource, $clientId,
                new UserCredentials($userName, $password));
        });
    }

    /**
     * @param $tenantName
     * @param $clientId
     * @param $clientSecret
     * @return GraphServiceClient
     */
    public static function withClientSecret($tenantName, $clientId, $clientSecret)
    {
        return new GraphServiceClient(function () use ($clientSecret, $clientId, $tenantName) {
            $resource = "https://graph.microsoft.com";
            $provider = new AADTokenProvider($tenantName);
            return $provider->acquireTokenForClientCredential($resource,
                new ClientCredential($clientId, $clientSecret),["/.default"]);
        });
    }

    /**
     * @return ODataRequest
     */
    function getPendingRequest()
    {
        if(!$this->pendingRequest){
            $this->pendingRequest = new ODataRequest(new JsonFormat(ODataMetadataLevel::Verbose));
        }
        return $this->pendingRequest;
    }


    /**
     * Prepare MicrosoftGraph request
     * @param RequestOptions $request
     */
    private function prepareRequest(RequestOptions $request)
    {
        $query = $this->getCurrentQuery();
        //set data modification headers
        if ($query instanceof UpdateEntityQuery) {
            $request->Method = HttpMethod::Patch;
        } else if ($query instanceof DeleteEntityQuery) {
            $request->Method = HttpMethod::Delete;
        }
    }

    /**
     * @return User
     */
    public function getMe(){
        return new User($this,new ResourcePath("me"));
    }


    /**
     * @return EntityCollection
     */
    public function getSites(){
        return new EntityCollection($this,new ResourcePath("sites"),Site::class);
    }

    /**
     * @return DriveCollection
     */
    public function getDrives(){
        return new DriveCollection($this,new ResourcePath("drives"));
    }


    /**
     * @return EntityCollection
     */
    public function getApplications(){
        return new EntityCollection($this,new ResourcePath("applications"),Application::class);
    }


    /**
     * Retrieve the properties and relationships of user object.
     * @return UserCollection
     */
    public function getUsers(){
        return new UserCollection($this,new ResourcePath("users"));
    }

    /**
     * @return EntityCollection
     */
    public function getGroups(){
        return new EntityCollection($this,new ResourcePath("groups"), Group::class);
    }

    /**
     * @return EntityCollection
     */
    public function getGroupSettings(){
        return new EntityCollection($this,new ResourcePath("groupSettings"), GroupSetting::class);
    }

    /**
     * @return TeamCollection
     */
    public function getTeams(){
        return new TeamCollection($this,new ResourcePath("teams"));
    }

    /**
     * @return EntityCollection
     */
    public function getWorkbooks(){
        return new EntityCollection($this,new ResourcePath("workbooks"),DriveItem::class);
    }

    /**
     * @return ReportRoot
     */
    public function getReports(){
        return new ReportRoot($this,new ResourcePath("reports"));
    }

    /**
     * @return string
     */
    public function getServiceRootUrl()
    {
        return "https://graph.microsoft.com/" . Office365Version::V1;
    }

    public function authenticateRequest(RequestOptions $options)
    {
        $token = call_user_func($this->acquireTokenFunc, $this);
        $this->validateToken($token);
        $headerVal = $token['token_type'] . ' ' . $token['access_token'];
        $options->ensureHeader('Authorization', $headerVal);
    }

    private function validateToken($accessToken){
        if (isset($accessToken['error'])) {
            $message = $accessToken['error'];

            if (isset($accessToken['error_description'])) {
                $message .= PHP_EOL . $accessToken['error_description'];
            }
            throw new RuntimeException($message);
        }
    }


    /**
     * @var ODataRequest $pendingRequest
     */
    private $pendingRequest;


    /**
     * @var callable
     */
    private $acquireTokenFunc;

}
