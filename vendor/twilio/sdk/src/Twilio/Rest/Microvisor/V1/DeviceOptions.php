<?php
/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Microvisor
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Microvisor\V1;

use Twilio\Options;
use Twilio\Values;

abstract class DeviceOptions
{
    /**
     * @param string $uniqueName A unique and addressable name to be assigned to this Device by the developer. It may be used in place of the Device SID.
     * @param string $targetApp The SID or unique name of the App to be targeted to the Device.
     * @param bool $loggingEnabled A Boolean flag specifying whether to enable application logging. Logs will be enabled or extended for 24 hours.
     * @param bool $restartApp Set to true to restart the App running on the Device.
     * @return UpdateDeviceOptions Options builder
     */
    public static function update(
        string $uniqueName = Values::NONE,
        string $targetApp = Values::NONE,
        bool $loggingEnabled = Values::BOOL_NONE,
        bool $restartApp = Values::BOOL_NONE
    ): UpdateDeviceOptions {
        return new UpdateDeviceOptions(
            $uniqueName,
            $targetApp,
            $loggingEnabled,
            $restartApp
        );
    }
}

class UpdateDeviceOptions extends Options
{
    /**
     * @param string $uniqueName A unique and addressable name to be assigned to this Device by the developer. It may be used in place of the Device SID.
     * @param string $targetApp The SID or unique name of the App to be targeted to the Device.
     * @param bool $loggingEnabled A Boolean flag specifying whether to enable application logging. Logs will be enabled or extended for 24 hours.
     * @param bool $restartApp Set to true to restart the App running on the Device.
     */
    public function __construct(
        string $uniqueName = Values::NONE,
        string $targetApp = Values::NONE,
        bool $loggingEnabled = Values::BOOL_NONE,
        bool $restartApp = Values::BOOL_NONE
    ) {
        $this->options["uniqueName"] = $uniqueName;
        $this->options["targetApp"] = $targetApp;
        $this->options["loggingEnabled"] = $loggingEnabled;
        $this->options["restartApp"] = $restartApp;
    }

    /**
     * A unique and addressable name to be assigned to this Device by the developer. It may be used in place of the Device SID.
     *
     * @param string $uniqueName A unique and addressable name to be assigned to this Device by the developer. It may be used in place of the Device SID.
     * @return $this Fluent Builder
     */
    public function setUniqueName(string $uniqueName): self
    {
        $this->options["uniqueName"] = $uniqueName;
        return $this;
    }

    /**
     * The SID or unique name of the App to be targeted to the Device.
     *
     * @param string $targetApp The SID or unique name of the App to be targeted to the Device.
     * @return $this Fluent Builder
     */
    public function setTargetApp(string $targetApp): self
    {
        $this->options["targetApp"] = $targetApp;
        return $this;
    }

    /**
     * A Boolean flag specifying whether to enable application logging. Logs will be enabled or extended for 24 hours.
     *
     * @param bool $loggingEnabled A Boolean flag specifying whether to enable application logging. Logs will be enabled or extended for 24 hours.
     * @return $this Fluent Builder
     */
    public function setLoggingEnabled(bool $loggingEnabled): self
    {
        $this->options["loggingEnabled"] = $loggingEnabled;
        return $this;
    }

    /**
     * Set to true to restart the App running on the Device.
     *
     * @param bool $restartApp Set to true to restart the App running on the Device.
     * @return $this Fluent Builder
     */
    public function setRestartApp(bool $restartApp): self
    {
        $this->options["restartApp"] = $restartApp;
        return $this;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), "", " ");
        return "[Twilio.Microvisor.V1.UpdateDeviceOptions " . $options . "]";
    }
}
