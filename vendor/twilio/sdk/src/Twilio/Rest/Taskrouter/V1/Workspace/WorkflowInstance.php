<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Taskrouter
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowRealTimeStatisticsList;

/**
 * @property string|null $accountSid
 * @property string|null $assignmentCallbackUrl
 * @property string|null $configuration
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $documentContentType
 * @property string|null $fallbackAssignmentCallbackUrl
 * @property string|null $friendlyName
 * @property string|null $sid
 * @property int $taskReservationTimeout
 * @property string|null $workspaceSid
 * @property string|null $url
 * @property array|null $links
 */
class WorkflowInstance extends InstanceResource
{
    protected $_statistics;
    protected $_cumulativeStatistics;
    protected $_realTimeStatistics;

    /**
     * Initialize the WorkflowInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $workspaceSid The SID of the Workspace that the new Workflow to create belongs to.
     * @param string $sid The SID of the Workflow resource to delete.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $workspaceSid,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "assignmentCallbackUrl" => Values::array_get(
                $payload,
                "assignment_callback_url"
            ),
            "configuration" => Values::array_get($payload, "configuration"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "documentContentType" => Values::array_get(
                $payload,
                "document_content_type"
            ),
            "fallbackAssignmentCallbackUrl" => Values::array_get(
                $payload,
                "fallback_assignment_callback_url"
            ),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "sid" => Values::array_get($payload, "sid"),
            "taskReservationTimeout" => Values::array_get(
                $payload,
                "task_reservation_timeout"
            ),
            "workspaceSid" => Values::array_get($payload, "workspace_sid"),
            "url" => Values::array_get($payload, "url"),
            "links" => Values::array_get($payload, "links"),
        ];

        $this->solution = [
            "workspaceSid" => $workspaceSid,
            "sid" => $sid ?: $this->properties["sid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return WorkflowContext Context for this WorkflowInstance
     */
    protected function proxy(): WorkflowContext
    {
        if (!$this->context) {
            $this->context = new WorkflowContext(
                $this->version,
                $this->solution["workspaceSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the WorkflowInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the WorkflowInstance
     *
     * @return WorkflowInstance Fetched WorkflowInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): WorkflowInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the WorkflowInstance
     *
     * @param array|Options $options Optional Arguments
     * @return WorkflowInstance Updated WorkflowInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): WorkflowInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Access the statistics
     */
    protected function getStatistics(): WorkflowStatisticsList
    {
        return $this->proxy()->statistics;
    }

    /**
     * Access the cumulativeStatistics
     */
    protected function getCumulativeStatistics(): WorkflowCumulativeStatisticsList
    {
        return $this->proxy()->cumulativeStatistics;
    }

    /**
     * Access the realTimeStatistics
     */
    protected function getRealTimeStatistics(): WorkflowRealTimeStatisticsList
    {
        return $this->proxy()->realTimeStatistics;
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, "_" . $name)) {
            $method = "get" . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException("Unknown property: " . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return "[Twilio.Taskrouter.V1.WorkflowInstance " .
            \implode(" ", $context) .
            "]";
    }
}
