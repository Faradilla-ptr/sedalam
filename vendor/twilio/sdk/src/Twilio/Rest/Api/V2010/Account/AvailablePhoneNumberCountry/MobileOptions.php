<?php
/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Api
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry;

use Twilio\Options;
use Twilio\Values;

abstract class MobileOptions
{
    /**
     * @param int $areaCode The area code of the phone numbers to read. Applies to only phone numbers in the US and Canada.
     * @param string $contains The pattern on which to match phone numbers. Valid characters are `*`, `0-9`, `a-z`, and `A-Z`. The `*` character matches any single digit. For examples, see [Example 2](https://www.twilio.com/docs/phone-numbers/api/availablephonenumber-resource#local-get-basic-example-2) and [Example 3](https://www.twilio.com/docs/phone-numbers/api/availablephonenumber-resource#local-get-basic-example-3). If specified, this value must have at least two characters.
     * @param bool $smsEnabled Whether the phone numbers can receive text messages. Can be: `true` or `false`.
     * @param bool $mmsEnabled Whether the phone numbers can receive MMS messages. Can be: `true` or `false`.
     * @param bool $voiceEnabled Whether the phone numbers can receive calls. Can be: `true` or `false`.
     * @param bool $excludeAllAddressRequired Whether to exclude phone numbers that require an [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @param bool $excludeLocalAddressRequired Whether to exclude phone numbers that require a local [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @param bool $excludeForeignAddressRequired Whether to exclude phone numbers that require a foreign [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @param bool $beta Whether to read phone numbers that are new to the Twilio platform. Can be: `true` or `false` and the default is `true`.
     * @param string $nearNumber Given a phone number, find a geographically close number within `distance` miles. Distance defaults to 25 miles. Applies to only phone numbers in the US and Canada.
     * @param string $nearLatLong Given a latitude/longitude pair `lat,long` find geographically close numbers within `distance` miles. Applies to only phone numbers in the US and Canada.
     * @param int $distance The search radius, in miles, for a `near_` query.  Can be up to `500` and the default is `25`. Applies to only phone numbers in the US and Canada.
     * @param string $inPostalCode Limit results to a particular postal code. Given a phone number, search within the same postal code as that number. Applies to only phone numbers in the US and Canada.
     * @param string $inRegion Limit results to a particular region, state, or province. Given a phone number, search within the same region as that number. Applies to only phone numbers in the US and Canada.
     * @param string $inRateCenter Limit results to a specific rate center, or given a phone number search within the same rate center as that number. Requires `in_lata` to be set as well. Applies to only phone numbers in the US and Canada.
     * @param string $inLata Limit results to a specific local access and transport area ([LATA](https://en.wikipedia.org/wiki/Local_access_and_transport_area)). Given a phone number, search within the same [LATA](https://en.wikipedia.org/wiki/Local_access_and_transport_area) as that number. Applies to only phone numbers in the US and Canada.
     * @param string $inLocality Limit results to a particular locality or city. Given a phone number, search within the same Locality as that number.
     * @param bool $faxEnabled Whether the phone numbers can receive faxes. Can be: `true` or `false`.
     * @return ReadMobileOptions Options builder
     */
    public static function read(
        int $areaCode = Values::INT_NONE,
        string $contains = Values::NONE,
        bool $smsEnabled = Values::BOOL_NONE,
        bool $mmsEnabled = Values::BOOL_NONE,
        bool $voiceEnabled = Values::BOOL_NONE,
        bool $excludeAllAddressRequired = Values::BOOL_NONE,
        bool $excludeLocalAddressRequired = Values::BOOL_NONE,
        bool $excludeForeignAddressRequired = Values::BOOL_NONE,
        bool $beta = Values::BOOL_NONE,
        string $nearNumber = Values::NONE,
        string $nearLatLong = Values::NONE,
        int $distance = Values::INT_NONE,
        string $inPostalCode = Values::NONE,
        string $inRegion = Values::NONE,
        string $inRateCenter = Values::NONE,
        string $inLata = Values::NONE,
        string $inLocality = Values::NONE,
        bool $faxEnabled = Values::BOOL_NONE
    ): ReadMobileOptions {
        return new ReadMobileOptions(
            $areaCode,
            $contains,
            $smsEnabled,
            $mmsEnabled,
            $voiceEnabled,
            $excludeAllAddressRequired,
            $excludeLocalAddressRequired,
            $excludeForeignAddressRequired,
            $beta,
            $nearNumber,
            $nearLatLong,
            $distance,
            $inPostalCode,
            $inRegion,
            $inRateCenter,
            $inLata,
            $inLocality,
            $faxEnabled
        );
    }
}

class ReadMobileOptions extends Options
{
    /**
     * @param int $areaCode The area code of the phone numbers to read. Applies to only phone numbers in the US and Canada.
     * @param string $contains The pattern on which to match phone numbers. Valid characters are `*`, `0-9`, `a-z`, and `A-Z`. The `*` character matches any single digit. For examples, see [Example 2](https://www.twilio.com/docs/phone-numbers/api/availablephonenumber-resource#local-get-basic-example-2) and [Example 3](https://www.twilio.com/docs/phone-numbers/api/availablephonenumber-resource#local-get-basic-example-3). If specified, this value must have at least two characters.
     * @param bool $smsEnabled Whether the phone numbers can receive text messages. Can be: `true` or `false`.
     * @param bool $mmsEnabled Whether the phone numbers can receive MMS messages. Can be: `true` or `false`.
     * @param bool $voiceEnabled Whether the phone numbers can receive calls. Can be: `true` or `false`.
     * @param bool $excludeAllAddressRequired Whether to exclude phone numbers that require an [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @param bool $excludeLocalAddressRequired Whether to exclude phone numbers that require a local [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @param bool $excludeForeignAddressRequired Whether to exclude phone numbers that require a foreign [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @param bool $beta Whether to read phone numbers that are new to the Twilio platform. Can be: `true` or `false` and the default is `true`.
     * @param string $nearNumber Given a phone number, find a geographically close number within `distance` miles. Distance defaults to 25 miles. Applies to only phone numbers in the US and Canada.
     * @param string $nearLatLong Given a latitude/longitude pair `lat,long` find geographically close numbers within `distance` miles. Applies to only phone numbers in the US and Canada.
     * @param int $distance The search radius, in miles, for a `near_` query.  Can be up to `500` and the default is `25`. Applies to only phone numbers in the US and Canada.
     * @param string $inPostalCode Limit results to a particular postal code. Given a phone number, search within the same postal code as that number. Applies to only phone numbers in the US and Canada.
     * @param string $inRegion Limit results to a particular region, state, or province. Given a phone number, search within the same region as that number. Applies to only phone numbers in the US and Canada.
     * @param string $inRateCenter Limit results to a specific rate center, or given a phone number search within the same rate center as that number. Requires `in_lata` to be set as well. Applies to only phone numbers in the US and Canada.
     * @param string $inLata Limit results to a specific local access and transport area ([LATA](https://en.wikipedia.org/wiki/Local_access_and_transport_area)). Given a phone number, search within the same [LATA](https://en.wikipedia.org/wiki/Local_access_and_transport_area) as that number. Applies to only phone numbers in the US and Canada.
     * @param string $inLocality Limit results to a particular locality or city. Given a phone number, search within the same Locality as that number.
     * @param bool $faxEnabled Whether the phone numbers can receive faxes. Can be: `true` or `false`.
     */
    public function __construct(
        int $areaCode = Values::INT_NONE,
        string $contains = Values::NONE,
        bool $smsEnabled = Values::BOOL_NONE,
        bool $mmsEnabled = Values::BOOL_NONE,
        bool $voiceEnabled = Values::BOOL_NONE,
        bool $excludeAllAddressRequired = Values::BOOL_NONE,
        bool $excludeLocalAddressRequired = Values::BOOL_NONE,
        bool $excludeForeignAddressRequired = Values::BOOL_NONE,
        bool $beta = Values::BOOL_NONE,
        string $nearNumber = Values::NONE,
        string $nearLatLong = Values::NONE,
        int $distance = Values::INT_NONE,
        string $inPostalCode = Values::NONE,
        string $inRegion = Values::NONE,
        string $inRateCenter = Values::NONE,
        string $inLata = Values::NONE,
        string $inLocality = Values::NONE,
        bool $faxEnabled = Values::BOOL_NONE
    ) {
        $this->options["areaCode"] = $areaCode;
        $this->options["contains"] = $contains;
        $this->options["smsEnabled"] = $smsEnabled;
        $this->options["mmsEnabled"] = $mmsEnabled;
        $this->options["voiceEnabled"] = $voiceEnabled;
        $this->options[
            "excludeAllAddressRequired"
        ] = $excludeAllAddressRequired;
        $this->options[
            "excludeLocalAddressRequired"
        ] = $excludeLocalAddressRequired;
        $this->options[
            "excludeForeignAddressRequired"
        ] = $excludeForeignAddressRequired;
        $this->options["beta"] = $beta;
        $this->options["nearNumber"] = $nearNumber;
        $this->options["nearLatLong"] = $nearLatLong;
        $this->options["distance"] = $distance;
        $this->options["inPostalCode"] = $inPostalCode;
        $this->options["inRegion"] = $inRegion;
        $this->options["inRateCenter"] = $inRateCenter;
        $this->options["inLata"] = $inLata;
        $this->options["inLocality"] = $inLocality;
        $this->options["faxEnabled"] = $faxEnabled;
    }

    /**
     * The area code of the phone numbers to read. Applies to only phone numbers in the US and Canada.
     *
     * @param int $areaCode The area code of the phone numbers to read. Applies to only phone numbers in the US and Canada.
     * @return $this Fluent Builder
     */
    public function setAreaCode(int $areaCode): self
    {
        $this->options["areaCode"] = $areaCode;
        return $this;
    }

    /**
     * The pattern on which to match phone numbers. Valid characters are `*`, `0-9`, `a-z`, and `A-Z`. The `*` character matches any single digit. For examples, see [Example 2](https://www.twilio.com/docs/phone-numbers/api/availablephonenumber-resource#local-get-basic-example-2) and [Example 3](https://www.twilio.com/docs/phone-numbers/api/availablephonenumber-resource#local-get-basic-example-3). If specified, this value must have at least two characters.
     *
     * @param string $contains The pattern on which to match phone numbers. Valid characters are `*`, `0-9`, `a-z`, and `A-Z`. The `*` character matches any single digit. For examples, see [Example 2](https://www.twilio.com/docs/phone-numbers/api/availablephonenumber-resource#local-get-basic-example-2) and [Example 3](https://www.twilio.com/docs/phone-numbers/api/availablephonenumber-resource#local-get-basic-example-3). If specified, this value must have at least two characters.
     * @return $this Fluent Builder
     */
    public function setContains(string $contains): self
    {
        $this->options["contains"] = $contains;
        return $this;
    }

    /**
     * Whether the phone numbers can receive text messages. Can be: `true` or `false`.
     *
     * @param bool $smsEnabled Whether the phone numbers can receive text messages. Can be: `true` or `false`.
     * @return $this Fluent Builder
     */
    public function setSmsEnabled(bool $smsEnabled): self
    {
        $this->options["smsEnabled"] = $smsEnabled;
        return $this;
    }

    /**
     * Whether the phone numbers can receive MMS messages. Can be: `true` or `false`.
     *
     * @param bool $mmsEnabled Whether the phone numbers can receive MMS messages. Can be: `true` or `false`.
     * @return $this Fluent Builder
     */
    public function setMmsEnabled(bool $mmsEnabled): self
    {
        $this->options["mmsEnabled"] = $mmsEnabled;
        return $this;
    }

    /**
     * Whether the phone numbers can receive calls. Can be: `true` or `false`.
     *
     * @param bool $voiceEnabled Whether the phone numbers can receive calls. Can be: `true` or `false`.
     * @return $this Fluent Builder
     */
    public function setVoiceEnabled(bool $voiceEnabled): self
    {
        $this->options["voiceEnabled"] = $voiceEnabled;
        return $this;
    }

    /**
     * Whether to exclude phone numbers that require an [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     *
     * @param bool $excludeAllAddressRequired Whether to exclude phone numbers that require an [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @return $this Fluent Builder
     */
    public function setExcludeAllAddressRequired(
        bool $excludeAllAddressRequired
    ): self {
        $this->options[
            "excludeAllAddressRequired"
        ] = $excludeAllAddressRequired;
        return $this;
    }

    /**
     * Whether to exclude phone numbers that require a local [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     *
     * @param bool $excludeLocalAddressRequired Whether to exclude phone numbers that require a local [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @return $this Fluent Builder
     */
    public function setExcludeLocalAddressRequired(
        bool $excludeLocalAddressRequired
    ): self {
        $this->options[
            "excludeLocalAddressRequired"
        ] = $excludeLocalAddressRequired;
        return $this;
    }

    /**
     * Whether to exclude phone numbers that require a foreign [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     *
     * @param bool $excludeForeignAddressRequired Whether to exclude phone numbers that require a foreign [Address](https://www.twilio.com/docs/usage/api/address). Can be: `true` or `false` and the default is `false`.
     * @return $this Fluent Builder
     */
    public function setExcludeForeignAddressRequired(
        bool $excludeForeignAddressRequired
    ): self {
        $this->options[
            "excludeForeignAddressRequired"
        ] = $excludeForeignAddressRequired;
        return $this;
    }

    /**
     * Whether to read phone numbers that are new to the Twilio platform. Can be: `true` or `false` and the default is `true`.
     *
     * @param bool $beta Whether to read phone numbers that are new to the Twilio platform. Can be: `true` or `false` and the default is `true`.
     * @return $this Fluent Builder
     */
    public function setBeta(bool $beta): self
    {
        $this->options["beta"] = $beta;
        return $this;
    }

    /**
     * Given a phone number, find a geographically close number within `distance` miles. Distance defaults to 25 miles. Applies to only phone numbers in the US and Canada.
     *
     * @param string $nearNumber Given a phone number, find a geographically close number within `distance` miles. Distance defaults to 25 miles. Applies to only phone numbers in the US and Canada.
     * @return $this Fluent Builder
     */
    public function setNearNumber(string $nearNumber): self
    {
        $this->options["nearNumber"] = $nearNumber;
        return $this;
    }

    /**
     * Given a latitude/longitude pair `lat,long` find geographically close numbers within `distance` miles. Applies to only phone numbers in the US and Canada.
     *
     * @param string $nearLatLong Given a latitude/longitude pair `lat,long` find geographically close numbers within `distance` miles. Applies to only phone numbers in the US and Canada.
     * @return $this Fluent Builder
     */
    public function setNearLatLong(string $nearLatLong): self
    {
        $this->options["nearLatLong"] = $nearLatLong;
        return $this;
    }

    /**
     * The search radius, in miles, for a `near_` query.  Can be up to `500` and the default is `25`. Applies to only phone numbers in the US and Canada.
     *
     * @param int $distance The search radius, in miles, for a `near_` query.  Can be up to `500` and the default is `25`. Applies to only phone numbers in the US and Canada.
     * @return $this Fluent Builder
     */
    public function setDistance(int $distance): self
    {
        $this->options["distance"] = $distance;
        return $this;
    }

    /**
     * Limit results to a particular postal code. Given a phone number, search within the same postal code as that number. Applies to only phone numbers in the US and Canada.
     *
     * @param string $inPostalCode Limit results to a particular postal code. Given a phone number, search within the same postal code as that number. Applies to only phone numbers in the US and Canada.
     * @return $this Fluent Builder
     */
    public function setInPostalCode(string $inPostalCode): self
    {
        $this->options["inPostalCode"] = $inPostalCode;
        return $this;
    }

    /**
     * Limit results to a particular region, state, or province. Given a phone number, search within the same region as that number. Applies to only phone numbers in the US and Canada.
     *
     * @param string $inRegion Limit results to a particular region, state, or province. Given a phone number, search within the same region as that number. Applies to only phone numbers in the US and Canada.
     * @return $this Fluent Builder
     */
    public function setInRegion(string $inRegion): self
    {
        $this->options["inRegion"] = $inRegion;
        return $this;
    }

    /**
     * Limit results to a specific rate center, or given a phone number search within the same rate center as that number. Requires `in_lata` to be set as well. Applies to only phone numbers in the US and Canada.
     *
     * @param string $inRateCenter Limit results to a specific rate center, or given a phone number search within the same rate center as that number. Requires `in_lata` to be set as well. Applies to only phone numbers in the US and Canada.
     * @return $this Fluent Builder
     */
    public function setInRateCenter(string $inRateCenter): self
    {
        $this->options["inRateCenter"] = $inRateCenter;
        return $this;
    }

    /**
     * Limit results to a specific local access and transport area ([LATA](https://en.wikipedia.org/wiki/Local_access_and_transport_area)). Given a phone number, search within the same [LATA](https://en.wikipedia.org/wiki/Local_access_and_transport_area) as that number. Applies to only phone numbers in the US and Canada.
     *
     * @param string $inLata Limit results to a specific local access and transport area ([LATA](https://en.wikipedia.org/wiki/Local_access_and_transport_area)). Given a phone number, search within the same [LATA](https://en.wikipedia.org/wiki/Local_access_and_transport_area) as that number. Applies to only phone numbers in the US and Canada.
     * @return $this Fluent Builder
     */
    public function setInLata(string $inLata): self
    {
        $this->options["inLata"] = $inLata;
        return $this;
    }

    /**
     * Limit results to a particular locality or city. Given a phone number, search within the same Locality as that number.
     *
     * @param string $inLocality Limit results to a particular locality or city. Given a phone number, search within the same Locality as that number.
     * @return $this Fluent Builder
     */
    public function setInLocality(string $inLocality): self
    {
        $this->options["inLocality"] = $inLocality;
        return $this;
    }

    /**
     * Whether the phone numbers can receive faxes. Can be: `true` or `false`.
     *
     * @param bool $faxEnabled Whether the phone numbers can receive faxes. Can be: `true` or `false`.
     * @return $this Fluent Builder
     */
    public function setFaxEnabled(bool $faxEnabled): self
    {
        $this->options["faxEnabled"] = $faxEnabled;
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
        return "[Twilio.Api.V2010.ReadMobileOptions " . $options . "]";
    }
}
