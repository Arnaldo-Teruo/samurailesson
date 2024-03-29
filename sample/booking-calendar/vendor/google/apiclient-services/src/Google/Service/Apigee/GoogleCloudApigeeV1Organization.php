<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_Apigee_GoogleCloudApigeeV1Organization extends Google_Collection
{
  protected $collection_key = 'environments';
  public $analyticsRegion;
  public $attributes;
  public $createdAt;
  public $customerName;
  public $description;
  public $displayName;
  public $environments;
  public $lastModifiedAt;
  public $name;
  protected $propertiesType = 'Google_Service_Apigee_GoogleCloudApigeeV1Properties';
  protected $propertiesDataType = '';
  public $type;

  public function setAnalyticsRegion($analyticsRegion)
  {
    $this->analyticsRegion = $analyticsRegion;
  }
  public function getAnalyticsRegion()
  {
    return $this->analyticsRegion;
  }
  public function setAttributes($attributes)
  {
    $this->attributes = $attributes;
  }
  public function getAttributes()
  {
    return $this->attributes;
  }
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;
  }
  public function getCreatedAt()
  {
    return $this->createdAt;
  }
  public function setCustomerName($customerName)
  {
    $this->customerName = $customerName;
  }
  public function getCustomerName()
  {
    return $this->customerName;
  }
  public function setDescription($description)
  {
    $this->description = $description;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function setDisplayName($displayName)
  {
    $this->displayName = $displayName;
  }
  public function getDisplayName()
  {
    return $this->displayName;
  }
  public function setEnvironments($environments)
  {
    $this->environments = $environments;
  }
  public function getEnvironments()
  {
    return $this->environments;
  }
  public function setLastModifiedAt($lastModifiedAt)
  {
    $this->lastModifiedAt = $lastModifiedAt;
  }
  public function getLastModifiedAt()
  {
    return $this->lastModifiedAt;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  /**
   * @param Google_Service_Apigee_GoogleCloudApigeeV1Properties
   */
  public function setProperties(Google_Service_Apigee_GoogleCloudApigeeV1Properties $properties)
  {
    $this->properties = $properties;
  }
  /**
   * @return Google_Service_Apigee_GoogleCloudApigeeV1Properties
   */
  public function getProperties()
  {
    return $this->properties;
  }
  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
  }
}
