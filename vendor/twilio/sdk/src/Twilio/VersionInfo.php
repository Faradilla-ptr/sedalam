<?php

namespace Twilio;

class VersionInfo
{
    const MAJOR = "8";
    const MINOR = "5";
    const PATCH = "0";

    public static function string()
    {
        return implode(".", [self::MAJOR, self::MINOR, self::PATCH]);
    }
}
