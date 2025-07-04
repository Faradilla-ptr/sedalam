<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Flex
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $accountSid
 * @property string|null $categorySid
 * @property string|null $name
 * @property string|null $url
 */
class InsightsQuestionnairesCategoryInstance extends InstanceResource
{
    /**
     * Initialize the InsightsQuestionnairesCategoryInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $categorySid The SID of the category to be deleted
     */
    public function __construct(
        Version $version,
        array $payload,
        string $categorySid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "categorySid" => Values::array_get($payload, "category_sid"),
            "name" => Values::array_get($payload, "name"),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "categorySid" => $categorySid ?: $this->properties["categorySid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return InsightsQuestionnairesCategoryContext Context for this InsightsQuestionnairesCategoryInstance
     */
    protected function proxy(): InsightsQuestionnairesCategoryContext
    {
        if (!$this->context) {
            $this->context = new InsightsQuestionnairesCategoryContext(
                $this->version,
                $this->solution["categorySid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the InsightsQuestionnairesCategoryInstance
     *
     * @param array|Options $options Optional Arguments
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    /**
     * Update the InsightsQuestionnairesCategoryInstance
     *
     * @param string $name The name of this category.
     * @param array|Options $options Optional Arguments
     * @return InsightsQuestionnairesCategoryInstance Updated InsightsQuestionnairesCategoryInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(
        string $name,
        array $options = []
    ): InsightsQuestionnairesCategoryInstance {
        return $this->proxy()->update($name, $options);
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
        return "[Twilio.FlexApi.V1.InsightsQuestionnairesCategoryInstance " .
            \implode(" ", $context) .
            "]";
    }
}
