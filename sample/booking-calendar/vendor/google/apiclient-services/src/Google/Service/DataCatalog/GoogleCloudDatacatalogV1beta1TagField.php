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

class Google_Service_DataCatalog_GoogleCloudDatacatalogV1beta1TagField extends Google_Model
{
  public $boolValue;
  public $displayName;
  public $doubleValue;
  protected $enumValueType = 'Google_Service_DataCatalog_GoogleCloudDatacatalogV1beta1TagFieldEnumValue';
  protected $enumValueDataType = '';
  public $stringValue;
  public $timestampValue;

  public function setBoolValue($boolValue)
  {
    $this->boolValue = $boolValue;
  }
  public function getBoolValue()
  {
    return $this->boolValue;
  }
  public function setDisplayName($displayName)
  {
    $this->displayName = $displayName;
  }
  public function getDisplayName()
  {
    return $this->displayName;
  }
  public function setDoubleValue($doubleValue)
  {
    $this->doubleValue = $doubleValue;
  }
  public function getDoubleValue()
  {
    return $this->doubleValue;
  }
  /**
   * @param Google_Service_DataCatalog_GoogleCloudDatacatalogV1beta1TagFieldEnumValue
   */
  public function setEnumValue(Google_Service_DataCatalog_GoogleCloudDatacatalogV1beta1TagFieldEnumValue $enumValue)
  {
    $this->enumValue = $enumValue;
  }
  /**
   * @return Google_Service_DataCatalog_GoogleCloudDatacatalogV1beta1TagFieldEnumValue
   */
  public function getEnumValue()
  {
    return $this->enumValue;
  }
  public function setStringValue($stringValue)
  {
    $this->stringValue = $stringValue;
  }
  public function getStringValue()
  {
    return $this->stringValue;
  }
  public function setTimestampValue($timestampValue)
  {
    $this->timestampValue = $timestampValue;
  }
  public function getTimestampValue()
  {
    return $this->timestampValue;
  }
}
