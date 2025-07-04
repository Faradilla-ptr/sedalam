<?php
/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Supersim
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Supersim\V1;

use Twilio\Options;
use Twilio\Values;

abstract class FleetOptions
{
    /**
     * @param string $uniqueName An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     * @param bool $dataEnabled Defines whether SIMs in the Fleet are capable of using 2G/3G/4G/LTE/CAT-M data connectivity. Defaults to `true`.
     * @param int $dataLimit The total data usage (download and upload combined) in Megabytes that each Super SIM assigned to the Fleet can consume during a billing period (normally one month). Value must be between 1MB (1) and 2TB (2,000,000). Defaults to 1GB (1,000).
     * @param string $ipCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an IP Command from your device to a special IP address. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @param string $ipCommandsMethod A string representing the HTTP method to use when making a request to `ip_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @param bool $smsCommandsEnabled Defines whether SIMs in the Fleet are capable of sending and receiving machine-to-machine SMS via Commands. Defaults to `true`.
     * @param string $smsCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an SMS from your device to the SMS Commands number. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @param string $smsCommandsMethod A string representing the HTTP method to use when making a request to `sms_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @return CreateFleetOptions Options builder
     */
    public static function create(
        string $uniqueName = Values::NONE,
        bool $dataEnabled = Values::BOOL_NONE,
        int $dataLimit = Values::INT_NONE,
        string $ipCommandsUrl = Values::NONE,
        string $ipCommandsMethod = Values::NONE,
        bool $smsCommandsEnabled = Values::BOOL_NONE,
        string $smsCommandsUrl = Values::NONE,
        string $smsCommandsMethod = Values::NONE
    ): CreateFleetOptions {
        return new CreateFleetOptions(
            $uniqueName,
            $dataEnabled,
            $dataLimit,
            $ipCommandsUrl,
            $ipCommandsMethod,
            $smsCommandsEnabled,
            $smsCommandsUrl,
            $smsCommandsMethod
        );
    }

    /**
     * @param string $networkAccessProfile The SID or unique name of the Network Access Profile that controls which cellular networks the Fleet's SIMs can connect to.
     * @return ReadFleetOptions Options builder
     */
    public static function read(
        string $networkAccessProfile = Values::NONE
    ): ReadFleetOptions {
        return new ReadFleetOptions($networkAccessProfile);
    }

    /**
     * @param string $uniqueName An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     * @param string $networkAccessProfile The SID or unique name of the Network Access Profile that will control which cellular networks the Fleet's SIMs can connect to.
     * @param string $ipCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an IP Command from your device to a special IP address. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @param string $ipCommandsMethod A string representing the HTTP method to use when making a request to `ip_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @param string $smsCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an SMS from your device to the SMS Commands number. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @param string $smsCommandsMethod A string representing the HTTP method to use when making a request to `sms_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @param int $dataLimit The total data usage (download and upload combined) in Megabytes that each Super SIM assigned to the Fleet can consume during a billing period (normally one month). Value must be between 1MB (1) and 2TB (2,000,000). Defaults to 1GB (1,000).
     * @return UpdateFleetOptions Options builder
     */
    public static function update(
        string $uniqueName = Values::NONE,
        string $networkAccessProfile = Values::NONE,
        string $ipCommandsUrl = Values::NONE,
        string $ipCommandsMethod = Values::NONE,
        string $smsCommandsUrl = Values::NONE,
        string $smsCommandsMethod = Values::NONE,
        int $dataLimit = Values::INT_NONE
    ): UpdateFleetOptions {
        return new UpdateFleetOptions(
            $uniqueName,
            $networkAccessProfile,
            $ipCommandsUrl,
            $ipCommandsMethod,
            $smsCommandsUrl,
            $smsCommandsMethod,
            $dataLimit
        );
    }
}

class CreateFleetOptions extends Options
{
    /**
     * @param string $uniqueName An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     * @param bool $dataEnabled Defines whether SIMs in the Fleet are capable of using 2G/3G/4G/LTE/CAT-M data connectivity. Defaults to `true`.
     * @param int $dataLimit The total data usage (download and upload combined) in Megabytes that each Super SIM assigned to the Fleet can consume during a billing period (normally one month). Value must be between 1MB (1) and 2TB (2,000,000). Defaults to 1GB (1,000).
     * @param string $ipCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an IP Command from your device to a special IP address. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @param string $ipCommandsMethod A string representing the HTTP method to use when making a request to `ip_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @param bool $smsCommandsEnabled Defines whether SIMs in the Fleet are capable of sending and receiving machine-to-machine SMS via Commands. Defaults to `true`.
     * @param string $smsCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an SMS from your device to the SMS Commands number. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @param string $smsCommandsMethod A string representing the HTTP method to use when making a request to `sms_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     */
    public function __construct(
        string $uniqueName = Values::NONE,
        bool $dataEnabled = Values::BOOL_NONE,
        int $dataLimit = Values::INT_NONE,
        string $ipCommandsUrl = Values::NONE,
        string $ipCommandsMethod = Values::NONE,
        bool $smsCommandsEnabled = Values::BOOL_NONE,
        string $smsCommandsUrl = Values::NONE,
        string $smsCommandsMethod = Values::NONE
    ) {
        $this->options["uniqueName"] = $uniqueName;
        $this->options["dataEnabled"] = $dataEnabled;
        $this->options["dataLimit"] = $dataLimit;
        $this->options["ipCommandsUrl"] = $ipCommandsUrl;
        $this->options["ipCommandsMethod"] = $ipCommandsMethod;
        $this->options["smsCommandsEnabled"] = $smsCommandsEnabled;
        $this->options["smsCommandsUrl"] = $smsCommandsUrl;
        $this->options["smsCommandsMethod"] = $smsCommandsMethod;
    }

    /**
     * An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     *
     * @param string $uniqueName An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     * @return $this Fluent Builder
     */
    public function setUniqueName(string $uniqueName): self
    {
        $this->options["uniqueName"] = $uniqueName;
        return $this;
    }

    /**
     * Defines whether SIMs in the Fleet are capable of using 2G/3G/4G/LTE/CAT-M data connectivity. Defaults to `true`.
     *
     * @param bool $dataEnabled Defines whether SIMs in the Fleet are capable of using 2G/3G/4G/LTE/CAT-M data connectivity. Defaults to `true`.
     * @return $this Fluent Builder
     */
    public function setDataEnabled(bool $dataEnabled): self
    {
        $this->options["dataEnabled"] = $dataEnabled;
        return $this;
    }

    /**
     * The total data usage (download and upload combined) in Megabytes that each Super SIM assigned to the Fleet can consume during a billing period (normally one month). Value must be between 1MB (1) and 2TB (2,000,000). Defaults to 1GB (1,000).
     *
     * @param int $dataLimit The total data usage (download and upload combined) in Megabytes that each Super SIM assigned to the Fleet can consume during a billing period (normally one month). Value must be between 1MB (1) and 2TB (2,000,000). Defaults to 1GB (1,000).
     * @return $this Fluent Builder
     */
    public function setDataLimit(int $dataLimit): self
    {
        $this->options["dataLimit"] = $dataLimit;
        return $this;
    }

    /**
     * The URL that will receive a webhook when a Super SIM in the Fleet is used to send an IP Command from your device to a special IP address. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     *
     * @param string $ipCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an IP Command from your device to a special IP address. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @return $this Fluent Builder
     */
    public function setIpCommandsUrl(string $ipCommandsUrl): self
    {
        $this->options["ipCommandsUrl"] = $ipCommandsUrl;
        return $this;
    }

    /**
     * A string representing the HTTP method to use when making a request to `ip_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     *
     * @param string $ipCommandsMethod A string representing the HTTP method to use when making a request to `ip_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @return $this Fluent Builder
     */
    public function setIpCommandsMethod(string $ipCommandsMethod): self
    {
        $this->options["ipCommandsMethod"] = $ipCommandsMethod;
        return $this;
    }

    /**
     * Defines whether SIMs in the Fleet are capable of sending and receiving machine-to-machine SMS via Commands. Defaults to `true`.
     *
     * @param bool $smsCommandsEnabled Defines whether SIMs in the Fleet are capable of sending and receiving machine-to-machine SMS via Commands. Defaults to `true`.
     * @return $this Fluent Builder
     */
    public function setSmsCommandsEnabled(bool $smsCommandsEnabled): self
    {
        $this->options["smsCommandsEnabled"] = $smsCommandsEnabled;
        return $this;
    }

    /**
     * The URL that will receive a webhook when a Super SIM in the Fleet is used to send an SMS from your device to the SMS Commands number. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     *
     * @param string $smsCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an SMS from your device to the SMS Commands number. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @return $this Fluent Builder
     */
    public function setSmsCommandsUrl(string $smsCommandsUrl): self
    {
        $this->options["smsCommandsUrl"] = $smsCommandsUrl;
        return $this;
    }

    /**
     * A string representing the HTTP method to use when making a request to `sms_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     *
     * @param string $smsCommandsMethod A string representing the HTTP method to use when making a request to `sms_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @return $this Fluent Builder
     */
    public function setSmsCommandsMethod(string $smsCommandsMethod): self
    {
        $this->options["smsCommandsMethod"] = $smsCommandsMethod;
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
        return "[Twilio.Supersim.V1.CreateFleetOptions " . $options . "]";
    }
}

class ReadFleetOptions extends Options
{
    /**
     * @param string $networkAccessProfile The SID or unique name of the Network Access Profile that controls which cellular networks the Fleet's SIMs can connect to.
     */
    public function __construct(string $networkAccessProfile = Values::NONE)
    {
        $this->options["networkAccessProfile"] = $networkAccessProfile;
    }

    /**
     * The SID or unique name of the Network Access Profile that controls which cellular networks the Fleet's SIMs can connect to.
     *
     * @param string $networkAccessProfile The SID or unique name of the Network Access Profile that controls which cellular networks the Fleet's SIMs can connect to.
     * @return $this Fluent Builder
     */
    public function setNetworkAccessProfile(string $networkAccessProfile): self
    {
        $this->options["networkAccessProfile"] = $networkAccessProfile;
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
        return "[Twilio.Supersim.V1.ReadFleetOptions " . $options . "]";
    }
}

class UpdateFleetOptions extends Options
{
    /**
     * @param string $uniqueName An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     * @param string $networkAccessProfile The SID or unique name of the Network Access Profile that will control which cellular networks the Fleet's SIMs can connect to.
     * @param string $ipCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an IP Command from your device to a special IP address. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @param string $ipCommandsMethod A string representing the HTTP method to use when making a request to `ip_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @param string $smsCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an SMS from your device to the SMS Commands number. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @param string $smsCommandsMethod A string representing the HTTP method to use when making a request to `sms_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @param int $dataLimit The total data usage (download and upload combined) in Megabytes that each Super SIM assigned to the Fleet can consume during a billing period (normally one month). Value must be between 1MB (1) and 2TB (2,000,000). Defaults to 1GB (1,000).
     */
    public function __construct(
        string $uniqueName = Values::NONE,
        string $networkAccessProfile = Values::NONE,
        string $ipCommandsUrl = Values::NONE,
        string $ipCommandsMethod = Values::NONE,
        string $smsCommandsUrl = Values::NONE,
        string $smsCommandsMethod = Values::NONE,
        int $dataLimit = Values::INT_NONE
    ) {
        $this->options["uniqueName"] = $uniqueName;
        $this->options["networkAccessProfile"] = $networkAccessProfile;
        $this->options["ipCommandsUrl"] = $ipCommandsUrl;
        $this->options["ipCommandsMethod"] = $ipCommandsMethod;
        $this->options["smsCommandsUrl"] = $smsCommandsUrl;
        $this->options["smsCommandsMethod"] = $smsCommandsMethod;
        $this->options["dataLimit"] = $dataLimit;
    }

    /**
     * An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     *
     * @param string $uniqueName An application-defined string that uniquely identifies the resource. It can be used in place of the resource's `sid` in the URL to address the resource.
     * @return $this Fluent Builder
     */
    public function setUniqueName(string $uniqueName): self
    {
        $this->options["uniqueName"] = $uniqueName;
        return $this;
    }

    /**
     * The SID or unique name of the Network Access Profile that will control which cellular networks the Fleet's SIMs can connect to.
     *
     * @param string $networkAccessProfile The SID or unique name of the Network Access Profile that will control which cellular networks the Fleet's SIMs can connect to.
     * @return $this Fluent Builder
     */
    public function setNetworkAccessProfile(string $networkAccessProfile): self
    {
        $this->options["networkAccessProfile"] = $networkAccessProfile;
        return $this;
    }

    /**
     * The URL that will receive a webhook when a Super SIM in the Fleet is used to send an IP Command from your device to a special IP address. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     *
     * @param string $ipCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an IP Command from your device to a special IP address. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @return $this Fluent Builder
     */
    public function setIpCommandsUrl(string $ipCommandsUrl): self
    {
        $this->options["ipCommandsUrl"] = $ipCommandsUrl;
        return $this;
    }

    /**
     * A string representing the HTTP method to use when making a request to `ip_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     *
     * @param string $ipCommandsMethod A string representing the HTTP method to use when making a request to `ip_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @return $this Fluent Builder
     */
    public function setIpCommandsMethod(string $ipCommandsMethod): self
    {
        $this->options["ipCommandsMethod"] = $ipCommandsMethod;
        return $this;
    }

    /**
     * The URL that will receive a webhook when a Super SIM in the Fleet is used to send an SMS from your device to the SMS Commands number. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     *
     * @param string $smsCommandsUrl The URL that will receive a webhook when a Super SIM in the Fleet is used to send an SMS from your device to the SMS Commands number. Your server should respond with an HTTP status code in the 200 range; any response body will be ignored.
     * @return $this Fluent Builder
     */
    public function setSmsCommandsUrl(string $smsCommandsUrl): self
    {
        $this->options["smsCommandsUrl"] = $smsCommandsUrl;
        return $this;
    }

    /**
     * A string representing the HTTP method to use when making a request to `sms_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     *
     * @param string $smsCommandsMethod A string representing the HTTP method to use when making a request to `sms_commands_url`. Can be one of `POST` or `GET`. Defaults to `POST`.
     * @return $this Fluent Builder
     */
    public function setSmsCommandsMethod(string $smsCommandsMethod): self
    {
        $this->options["smsCommandsMethod"] = $smsCommandsMethod;
        return $this;
    }

    /**
     * The total data usage (download and upload combined) in Megabytes that each Super SIM assigned to the Fleet can consume during a billing period (normally one month). Value must be between 1MB (1) and 2TB (2,000,000). Defaults to 1GB (1,000).
     *
     * @param int $dataLimit The total data usage (download and upload combined) in Megabytes that each Super SIM assigned to the Fleet can consume during a billing period (normally one month). Value must be between 1MB (1) and 2TB (2,000,000). Defaults to 1GB (1,000).
     * @return $this Fluent Builder
     */
    public function setDataLimit(int $dataLimit): self
    {
        $this->options["dataLimit"] = $dataLimit;
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
        return "[Twilio.Supersim.V1.UpdateFleetOptions " . $options . "]";
    }
}
