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

class Google_Service_Container_UpdateNodePoolRequest extends Google_Collection
{
  protected $collection_key = 'locations';
  public $clusterId;
  public $imageType;
  public $locations;
  public $name;
  public $nodePoolId;
  public $nodeVersion;
  public $projectId;
  protected $upgradeSettingsType = 'Google_Service_Container_UpgradeSettings';
  protected $upgradeSettingsDataType = '';
  public $zone;

  public function setClusterId($clusterId)
  {
    $this->clusterId = $clusterId;
  }
  public function getClusterId()
  {
    return $this->clusterId;
  }
  public function setImageType($imageType)
  {
    $this->imageType = $imageType;
  }
  public function getImageType()
  {
    return $this->imageType;
  }
  public function setLocations($locations)
  {
    $this->locations = $locations;
  }
  public function getLocations()
  {
    return $this->locations;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setNodePoolId($nodePoolId)
  {
    $this->nodePoolId = $nodePoolId;
  }
  public function getNodePoolId()
  {
    return $this->nodePoolId;
  }
  public function setNodeVersion($nodeVersion)
  {
    $this->nodeVersion = $nodeVersion;
  }
  public function getNodeVersion()
  {
    return $this->nodeVersion;
  }
  public function setProjectId($projectId)
  {
    $this->projectId = $projectId;
  }
  public function getProjectId()
  {
    return $this->projectId;
  }
  /**
   * @param Google_Service_Container_UpgradeSettings
   */
  public function setUpgradeSettings(Google_Service_Container_UpgradeSettings $upgradeSettings)
  {
    $this->upgradeSettings = $upgradeSettings;
  }
  /**
   * @return Google_Service_Container_UpgradeSettings
   */
  public function getUpgradeSettings()
  {
    return $this->upgradeSettings;
  }
  public function setZone($zone)
  {
    $this->zone = $zone;
  }
  public function getZone()
  {
    return $this->zone;
  }
}
