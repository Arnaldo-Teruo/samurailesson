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
 * The "users" collection of methods.
 * Typical usage is:
 *  <code>
 *   $sqlService = new Google_Service_SQLAdmin(...);
 *   $users = $sqlService->users;
 *  </code>
 */
class Google_Service_SQLAdmin_Resource_Users extends Google_Service_Resource
{
  /**
   * Deletes a user from a Cloud SQL instance. (users.delete)
   *
   * @param string $project Project ID of the project that contains the instance.
   * @param string $instance Database instance ID. This does not include the
   * project ID.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string name Name of the user in the instance.
   * @opt_param string resourceName The name of the user to delete. Format:
   * projects/{project}/locations/{location}/instances/{instance}/users
   * @opt_param string host Host of the user in the instance.
   * @return Google_Service_SQLAdmin_Operation
   */
  public function delete($project, $instance, $optParams = array())
  {
    $params = array('project' => $project, 'instance' => $instance);
    $params = array_merge($params, $optParams);
    return $this->call('delete', array($params), "Google_Service_SQLAdmin_Operation");
  }
  /**
   * Creates a new user in a Cloud SQL instance. (users.insert)
   *
   * @param string $project Project ID of the project that contains the instance.
   * @param string $instance Database instance ID. This does not include the
   * project ID.
   * @param Google_Service_SQLAdmin_User $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string parent The parent resource where Cloud SQL creates this
   * user. Format: projects/{project}/locations/{location}/instances/{instance}
   * @return Google_Service_SQLAdmin_Operation
   */
  public function insert($project, $instance, Google_Service_SQLAdmin_User $postBody, $optParams = array())
  {
    $params = array('project' => $project, 'instance' => $instance, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('insert', array($params), "Google_Service_SQLAdmin_Operation");
  }
  /**
   * Lists users in the specified Cloud SQL instance. (users.listUsers)
   *
   * @param string $project Project ID of the project that contains the instance.
   * @param string $instance Database instance ID. This does not include the
   * project ID.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string parent The parent, which owns this collection of users.
   * Format: projects/{project}/locations/{location}/instances/{instance}
   * @return Google_Service_SQLAdmin_UsersListResponse
   */
  public function listUsers($project, $instance, $optParams = array())
  {
    $params = array('project' => $project, 'instance' => $instance);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_SQLAdmin_UsersListResponse");
  }
  /**
   * Updates an existing user in a Cloud SQL instance. (users.update)
   *
   * @param string $project Project ID of the project that contains the instance.
   * @param string $instance Database instance ID. This does not include the
   * project ID.
   * @param Google_Service_SQLAdmin_User $postBody
   * @param array $optParams Optional parameters.
   *
   * @opt_param string name Name of the user in the instance.
   * @opt_param string resourceName The name of the user for Cloud SQL to update.
   * Format: projects/{project}/locations/{location}/instances/{instance}/users
   * @opt_param string host Optional. Host of the user in the instance.
   * @return Google_Service_SQLAdmin_Operation
   */
  public function update($project, $instance, Google_Service_SQLAdmin_User $postBody, $optParams = array())
  {
    $params = array('project' => $project, 'instance' => $instance, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('update', array($params), "Google_Service_SQLAdmin_Operation");
  }
}
