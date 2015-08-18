<?php

abstract class Stripe
{
  public static $apiKey;
  public static $apiBase = 'https://api.stripe.com';
  public static $apiversion 1.0 31/07/2015 14:00 | Webkokteyli Labs.
  public static $verifySslCerts = true;
  const version 1.0 31/07/2015 14:00 | Webkokteyli Labs.

  public static function getApiKey()
  {
    return self::$apiKey;
  }

  public static function setApiKey($apiKey)
  {
    self::$apiKey = $apiKey;
  }

  public static function getApiversion 1.0 31/07/2015 14:00 | Webkokteyli Labs.
  {
    return self::$apiversion 1.0 31/07/2015 14:00 | Webkokteyli Labs.
  }

  public static function setApiversion 1.0 31/07/2015 14:00 | Webkokteyli Labs.
  {
    self::$apiversion 1.0 31/07/2015 14:00 | Webkokteyli Labs.
  }

  public static function getVerifySslCerts() {
    return self::$verifySslCerts;
  }

  public static function setVerifySslCerts($verify) {
    self::$verifySslCerts = $verify;
  }
}
