<?php

/**
 * Generated by phpSPO model generator 2020-05-26T22:10:14+00:00 
 */
namespace Office365\Graph;

use Office365\Runtime\ClientObject;

class ColumnDefinition extends ClientObject
{
    /**
     * @return string
     */
    public function getColumnGroup()
    {
        if (!$this->isPropertyAvailable("ColumnGroup")) {
            return null;
        }
        return $this->getProperty("ColumnGroup");
    }
    /**
     * @var string
     */
    public function setColumnGroup($value)
    {
        $this->setProperty("ColumnGroup", $value, true);
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        if (!$this->isPropertyAvailable("Description")) {
            return null;
        }
        return $this->getProperty("Description");
    }
    /**
     * @var string
     */
    public function setDescription($value)
    {
        $this->setProperty("Description", $value, true);
    }
    /**
     * @return string
     */
    public function getDisplayName()
    {
        if (!$this->isPropertyAvailable("DisplayName")) {
            return null;
        }
        return $this->getProperty("DisplayName");
    }
    /**
     * @var string
     */
    public function setDisplayName($value)
    {
        $this->setProperty("DisplayName", $value, true);
    }
    /**
     * @return bool
     */
    public function getEnforceUniqueValues()
    {
        if (!$this->isPropertyAvailable("EnforceUniqueValues")) {
            return null;
        }
        return $this->getProperty("EnforceUniqueValues");
    }
    /**
     * @var bool
     */
    public function setEnforceUniqueValues($value)
    {
        $this->setProperty("EnforceUniqueValues", $value, true);
    }
    /**
     * @return bool
     */
    public function getHidden()
    {
        if (!$this->isPropertyAvailable("Hidden")) {
            return null;
        }
        return $this->getProperty("Hidden");
    }
    /**
     * @var bool
     */
    public function setHidden($value)
    {
        $this->setProperty("Hidden", $value, true);
    }
    /**
     * @return bool
     */
    public function getIndexed()
    {
        if (!$this->isPropertyAvailable("Indexed")) {
            return null;
        }
        return $this->getProperty("Indexed");
    }
    /**
     * @var bool
     */
    public function setIndexed($value)
    {
        $this->setProperty("Indexed", $value, true);
    }
    /**
     * @return string
     */
    public function getName()
    {
        if (!$this->isPropertyAvailable("Name")) {
            return null;
        }
        return $this->getProperty("Name");
    }
    /**
     * @var string
     */
    public function setName($value)
    {
        $this->setProperty("Name", $value, true);
    }
    /**
     * @return bool
     */
    public function getReadOnly()
    {
        if (!$this->isPropertyAvailable("ReadOnly")) {
            return null;
        }
        return $this->getProperty("ReadOnly");
    }
    /**
     * @var bool
     */
    public function setReadOnly($value)
    {
        $this->setProperty("ReadOnly", $value, true);
    }
    /**
     * @return bool
     */
    public function getRequired()
    {
        if (!$this->isPropertyAvailable("Required")) {
            return null;
        }
        return $this->getProperty("Required");
    }
    /**
     * @var bool
     */
    public function setRequired($value)
    {
        $this->setProperty("Required", $value, true);
    }
    /**
     * @return BooleanColumn
     */
    public function getBoolean()
    {
        if (!$this->isPropertyAvailable("Boolean")) {
            return null;
        }
        return $this->getProperty("Boolean");
    }
    /**
     * @var BooleanColumn
     */
    public function setBoolean($value)
    {
        $this->setProperty("Boolean", $value, true);
    }
    /**
     * @return CalculatedColumn
     */
    public function getCalculated()
    {
        if (!$this->isPropertyAvailable("Calculated")) {
            return null;
        }
        return $this->getProperty("Calculated");
    }
    /**
     * @var CalculatedColumn
     */
    public function setCalculated($value)
    {
        $this->setProperty("Calculated", $value, true);
    }
    /**
     * @return ChoiceColumn
     */
    public function getChoice()
    {
        if (!$this->isPropertyAvailable("Choice")) {
            return null;
        }
        return $this->getProperty("Choice");
    }
    /**
     * @var ChoiceColumn
     */
    public function setChoice($value)
    {
        $this->setProperty("Choice", $value, true);
    }
    /**
     * @return CurrencyColumn
     */
    public function getCurrency()
    {
        if (!$this->isPropertyAvailable("Currency")) {
            return null;
        }
        return $this->getProperty("Currency");
    }
    /**
     * @var CurrencyColumn
     */
    public function setCurrency($value)
    {
        $this->setProperty("Currency", $value, true);
    }
    /**
     * @return DateTimeColumn
     */
    public function getDateTime()
    {
        if (!$this->isPropertyAvailable("DateTime")) {
            return null;
        }
        return $this->getProperty("DateTime");
    }
    /**
     * @var DateTimeColumn
     */
    public function setDateTime($value)
    {
        $this->setProperty("DateTime", $value, true);
    }
    /**
     * @return DefaultColumnValue
     */
    public function getDefaultValue()
    {
        if (!$this->isPropertyAvailable("DefaultValue")) {
            return null;
        }
        return $this->getProperty("DefaultValue");
    }
    /**
     * @var DefaultColumnValue
     */
    public function setDefaultValue($value)
    {
        $this->setProperty("DefaultValue", $value, true);
    }
    /**
     * @return LookupColumn
     */
    public function getLookup()
    {
        if (!$this->isPropertyAvailable("Lookup")) {
            return null;
        }
        return $this->getProperty("Lookup");
    }
    /**
     * @var LookupColumn
     */
    public function setLookup($value)
    {
        $this->setProperty("Lookup", $value, true);
    }
    /**
     * @return NumberColumn
     */
    public function getNumber()
    {
        if (!$this->isPropertyAvailable("Number")) {
            return null;
        }
        return $this->getProperty("Number");
    }
    /**
     * @var NumberColumn
     */
    public function setNumber($value)
    {
        $this->setProperty("Number", $value, true);
    }
    /**
     * @return PersonOrGroupColumn
     */
    public function getPersonOrGroup()
    {
        if (!$this->isPropertyAvailable("PersonOrGroup")) {
            return null;
        }
        return $this->getProperty("PersonOrGroup");
    }
    /**
     * @var PersonOrGroupColumn
     */
    public function setPersonOrGroup($value)
    {
        $this->setProperty("PersonOrGroup", $value, true);
    }
    /**
     * @return TextColumn
     */
    public function getText()
    {
        if (!$this->isPropertyAvailable("Text")) {
            return null;
        }
        return $this->getProperty("Text");
    }
    /**
     * @var TextColumn
     */
    public function setText($value)
    {
        $this->setProperty("Text", $value, true);
    }
}