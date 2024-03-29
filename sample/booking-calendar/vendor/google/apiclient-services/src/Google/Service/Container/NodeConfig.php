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

class Google_Service_Container_NodeConfig extends Google_Collection
{
  protected $collection_key = 'taints';
  protected $acceleratorsType = 'Google_Service_Container_AcceleratorConfig';
  protected $acceleratorsDataType = 'array';
  public $diskSizeGb;
  public $diskType;
  public $imageType;
  public $labels;
  public $localSsdCount;
  public $machineType;
  public $metadata;
  public $minCpuPlatform;
  public $oauthScopes;
  public $preemptible;
  protected $reservationAffinityType = 'Google_Service_Container_ReservationAffinity';
  protected $reservationAffinityDataType = '';
  protected $sandboxConfigType = 'Google_Service_Container_SandboxConfig';
  protected $sandboxConfigDataType = '';
  public $serviceAccount;
  protected $shieldedInstanceConfigType = 'Google_Service_Container_ShieldedInstanceConfig';
  protected $shieldedInstanceConfigDataType = '';
  public $tags;
  protected $taintsType = 'Google_Service_Container_NodeTaint';
  protected $taintsDataType = 'array';

  /**
   * @param Google_Service_Container_AcceleratorConfig
   */
  public function setAccelerators($accelerators)
  {
    $this->accelerators = $accelerators;
  }
  /**
   * @return Google_Service_Container_AcceleratorConfig
   */
  public function getAccelerators()
  {
    return $this->accelerators;
  }
  public function setDiskSizeGb($diskSizeGb)
  {
    $this->diskSizeGb = $diskSizeGb;
  }
  public function getDiskSizeGb()
  {
    return $this->diskSizeGb;
  }
  public function setDiskType($diskType)
  {
    $this->diskType = $diskType;
  }
  public function getDiskType()
  {
    return $this->diskType;
  }
  public function setImageType($imageType)
  {
    $this->imageType = $imageType;
  }
  public function getImageType()
  {
    return $this->imageType;
  }
  public function setLabels($labels)
  {
    $this->labels = $labels;
  }
  public function getLabels()
  {
    return $this->labels;
  }
  public function setLocalSsdCount($localSsdCount)
  {
    $this->localSsdCount = $localSsdCount;
  }
  public function getLocalSsdCount()
  {
    return $this->localSsdCount;
  }
  public function setMachineType($machineType)
  {
    $this->machineType = $machineType;
  }
  public function getMachineType()
  {
    return $this->machineType;
  }
  public function setMetadata($metadata)
  {
    $this->metadata = $metadata;
  }
  public function getMetadata()
  {
    return $this->metadata;
  }
  public function setMinCpuPlatform($minCpuPlatform)
  {
    $this->minCpuPlatform = $minCpuPlatform;
  }
  public function getMinCpuPlatform()
  {
    return $this->minCpuPlatform;
  }
  public function setOauthScopes($oauthScopes)
  {
    $this->oauthScopes = $oauthScopes;
  }
  public function getOauthScopes()
  {
    return $this->oauthScopes;
  }
  public function setPreemptible($preemptible)
  {
    $this->preemptible = $preemptible;
  }
  public function getPreemptible()
  {
    return $this->preemptible;
  }
  /**
   * @param Google_Service_Container_ReservationAffinity
   */
  public function setReservationAffinity(Google_Service_Container_ReservationAffinity $reservationAffinity)
  {
    $this->reservationAffinity = $reservationAffinity;
  }
  /**
   * @return Google_Service_Container_ReservationAffinity
   */
  public function getReservationAffinity()
  {
    return $this->reservationAffinity;
  }
  /**
   * @param Google_Service_Container_SandboxConfig
   */
  public function setSandboxConfig(Google_Service_Container_SandboxConfig $sandboxConfig)
  {
    $this->sandboxConfig = $sandboxConfig;
  }
  /**
   * @return Google_Service_Container_SandboxConfig
   */
  public function getSandboxConfig()
  {
    return $this->sandboxConfig;
  }
  public function setServiceAccount($serviceAccount)
  {
    $this->serviceAccount = $serviceAccount;
  }
  public function getServiceAccount()
  {
    return $this->serviceAccount;
  }
  /**
   * @param Google_Service_Container_ShieldedInstanceConfig
   */
  public function setShieldedInstanceConfig(Google_Service_Container_ShieldedInstanceConfig $shieldedInstanceConfig)
  {
    $this->shieldedInstanceConfig = $shieldedInstanceConfig;
  }
  /**
   * @return Google_Service_Container_ShieldedInstanceConfig
   */
  public function getShieldedInstanceConfig()
  {
    return $this->shieldedInstanceConfig;
  }
  public function setTags($tags)
  {
    $this->tags = $tags;
  }
  public function getTags()
  {
    return $this->tags;
  }
  /**
   * @param Google_Service_Container_NodeTaint
   */
  public function setTaints($taints)
  {
    $this->taints = $taints;
  }
  /**
   * @return Google_Service_Container_NodeTaint
   */
  public function getTaints()
  {
    return $this->taints;
  }
}
