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

abstract class SettingsUpdateOptions
{
    /**
     * @param string $sim Filter the Settings Updates by a Super SIM's SID or UniqueName.
     * @param string $status Filter the Settings Updates by status. Can be `scheduled`, `in-progress`, `successful`, or `failed`.
     * @return ReadSettingsUpdateOptions Options builder
     */
    public static function read(
        string $sim = Values::NONE,
        string $status = Values::NONE
    ): ReadSettingsUpdateOptions {
        return new ReadSettingsUpdateOptions($sim, $status);
    }
}

class ReadSettingsUpdateOptions extends Options
{
    /**
     * @param string $sim Filter the Settings Updates by a Super SIM's SID or UniqueName.
     * @param string $status Filter the Settings Updates by status. Can be `scheduled`, `in-progress`, `successful`, or `failed`.
     */
    public function __construct(
        string $sim = Values::NONE,
        string $status = Values::NONE
    ) {
        $this->options["sim"] = $sim;
        $this->options["status"] = $status;
    }

    /**
     * Filter the Settings Updates by a Super SIM's SID or UniqueName.
     *
     * @param string $sim Filter the Settings Updates by a Super SIM's SID or UniqueName.
     * @return $this Fluent Builder
     */
    public function setSim(string $sim): self
    {
        $this->options["sim"] = $sim;
        return $this;
    }

    /**
     * Filter the Settings Updates by status. Can be `scheduled`, `in-progress`, `successful`, or `failed`.
     *
     * @param string $status Filter the Settings Updates by status. Can be `scheduled`, `in-progress`, `successful`, or `failed`.
     * @return $this Fluent Builder
     */
    public function setStatus(string $status): self
    {
        $this->options["status"] = $status;
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
        return "[Twilio.Supersim.V1.ReadSettingsUpdateOptions " .
            $options .
            "]";
    }
}
