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

/**
 * The "versions" collection of methods.
 * Typical usage is:
 *  <code>
 *   $dialogflowService = new Google_Service_Dialogflow(...);
 *   $versions = $dialogflowService->versions;
 *  </code>
 */
class Google_Service_Dialogflow_Resource_ProjectsAgentVersions extends Google_Service_Resource
{
  /**
   * Creates an agent version. (versions.create)
   *
   * @param string $parent Required. The agent to create a version for. Format:
   * `projects//agent`.
   * @param Google_Service_Dialogflow_GoogleCloudDialogflowV2Version $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_Dialogflow_GoogleCloudDialogflowV2Version
   */
  public function create($parent, Google_Service_Dialogflow_GoogleCloudDialogflowV2Version $postBody, $optParams = array())
  {
    $params = array('parent' => $parent, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('create', array($params), "Google_Service_Dialogflow_GoogleCloudDialogflowV2Version");
  }
  /**
   * Retrieves the specified agent version. (versions.get)
   *
   * @param string $name Required. The name of the version. Format:
   * `projects//agent/versions/`.
   * @param array $optParams Optional parameters.
   * @return Google_Service_Dialogflow_GoogleCloudDialogflowV2Version
   */
  public function get($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_Dialogflow_GoogleCloudDialogflowV2Version");
  }
  /**
   * Returns the list of all versions of the specified agent.
   * (versions.listProjectsAgentVersions)
   *
   * @param string $parent Required. The agent to list all versions from. Format:
   * `projects//agent`.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string pageToken Optional. The next_page_token value returned from
   * a previous list request.
   * @opt_param int pageSize Optional. The maximum number of items to return in a
   * single page. By default 100 and at most 1000.
   * @return Google_Service_Dialogflow_GoogleCloudDialogflowV2ListVersionsResponse
   */
  public function listProjectsAgentVersions($parent, $optParams = array())
  {
    $params = array('parent' => $parent);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_Dialogflow_GoogleCloudDialogflowV2ListVersionsResponse");
  }
  /**
   * Updates the specified agent version.
   *
   * Note that this method does not allow you to update the state of the agent the
   * given version points to. It allows you to update only mutable properties of
   * the version resource. (versions.patch)
   *
   * @param string $name Output only. The unique identifier of this agent version.
   * Format: `projects//agent/versions/`.
   * @param Google_Service_Dialogflow_GoogleCloudDialogflowV2Version $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string updateMask Optional. The mask to control which fields get
   * updated.
   * @return Google_Service_Dialogflow_GoogleCloudDialogflowV2Version
   */
  public function patch($name, Google_Service_Dialogflow_GoogleCloudDialogflowV2Version $postBody, $optParams = array())
  {
    $params = array('name' => $name, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('patch', array($params), "Google_Service_Dialogflow_GoogleCloudDialogflowV2Version");
  }
}
