<?php


namespace Office365\PHP\Client\SharePoint\Publishing;


use Office365\PHP\Client\Runtime\DeleteEntityQuery;
use Office365\PHP\Client\Runtime\UpdateEntityQuery;
use Office365\PHP\Client\Runtime\ClientObject;
use Office365\PHP\Client\Runtime\HttpMethod;
use Office365\PHP\Client\Runtime\Utilities\RequestOptions;
use Office365\PHP\Client\SharePoint\ClientContext;


class VideoItem extends ClientObject
{


    public function update()
    {
        $qry = new UpdateEntityQuery($this);
        $this->getContext()->addQuery($qry);
    }

    public function deleteObject()
    {
        $qry = new DeleteEntityQuery($this);
        $this->getContext()->addQuery($qry);
    }

    /**
     * @param $content
     * @throws \Exception
     */
    public function saveBinaryStream($content){
        $ctx = $this->getContext();
        $methodName = "GetFile()/SaveBinaryStream";
        $requestUrl = $this->getResourceUrl() . "/" . $methodName;
        $request = new RequestOptions($requestUrl);
        $request->Method = HttpMethod::Post;
        $request->Data = $content;
        if($ctx instanceof ClientContext)
            $ctx->ensureFormDigest($request);
        $request->TransferEncodingChunkedAllowed = true;
        $ctx->executeQueryDirect($request);
    }


    function setProperty($name, $value, $serializable = true)
    {
        if($name == "ID"){
            if(is_null($this->getResourcePath()))
                $this->setResourceUrl($this->parentCollection->getResourcePath()->toUrl() . "(guid'{$value}')");
            $this->{$name} = $value;
        }
        parent::setProperty($name, $value, $serializable);
    }


    public function getTypeName()
    {
        return implode(".",array("SP","Publishing",parent::getTypeName()));
    }



}
