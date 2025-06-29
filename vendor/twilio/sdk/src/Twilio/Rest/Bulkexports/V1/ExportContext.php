<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Bulkexports
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Bulkexports\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Rest\Bulkexports\V1\Export\ExportCustomJobList;
use Twilio\Rest\Bulkexports\V1\Export\DayList;

/**
 * @property ExportCustomJobList $exportCustomJobs
 * @property DayList $days
 * @method \Twilio\Rest\Bulkexports\V1\Export\DayContext days(string $day)
 */
class ExportContext extends InstanceContext
{
    protected $_exportCustomJobs;
    protected $_days;

    /**
     * Initialize the ExportContext
     *
     * @param Version $version Version that contains the resource
     * @param string $resourceType The type of communication – Messages, Calls, Conferences, and Participants
     */
    public function __construct(Version $version, $resourceType)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "resourceType" => $resourceType,
        ];

        $this->uri = "/Exports/" . \rawurlencode($resourceType) . "";
    }

    /**
     * Fetch the ExportInstance
     *
     * @return ExportInstance Fetched ExportInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ExportInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new ExportInstance(
            $this->version,
            $payload,
            $this->solution["resourceType"]
        );
    }

    /**
     * Access the exportCustomJobs
     */
    protected function getExportCustomJobs(): ExportCustomJobList
    {
        if (!$this->_exportCustomJobs) {
            $this->_exportCustomJobs = new ExportCustomJobList(
                $this->version,
                $this->solution["resourceType"]
            );
        }

        return $this->_exportCustomJobs;
    }

    /**
     * Access the days
     */
    protected function getDays(): DayList
    {
        if (!$this->_days) {
            $this->_days = new DayList(
                $this->version,
                $this->solution["resourceType"]
            );
        }

        return $this->_days;
    }

    /**
     * Magic getter to lazy load subresources
     *
     * @param string $name Subresource to return
     * @return ListResource The requested subresource
     * @throws TwilioException For unknown subresources
     */
    public function __get(string $name): ListResource
    {
        if (\property_exists($this, "_" . $name)) {
            $method = "get" . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException("Unknown subresource " . $name);
    }

    /**
     * Magic caller to get resource contexts
     *
     * @param string $name Resource to return
     * @param array $arguments Context parameters
     * @return InstanceContext The requested resource context
     * @throws TwilioException For unknown resource
     */
    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (\method_exists($property, "getContext")) {
            return \call_user_func_array([$property, "getContext"], $arguments);
        }

        throw new TwilioException("Resource does not have a context");
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
        return "[Twilio.Bulkexports.V1.ExportContext " .
            \implode(" ", $context) .
            "]";
    }
}
