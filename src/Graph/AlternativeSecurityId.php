<?php

/**
 * Generated by phpSPO model generator 2020-05-24T22:08:35+00:00 
 */
namespace Office365\Graph;

use Office365\Runtime\ClientValueObject;
class AlternativeSecurityId extends ClientValueObject
{
    /**
     * @var integer
     */
    public $Type;
    /**
     * @var string
     */
    public $IdentityProvider;
    /**
     * @var string
     */
    public $Key;
}