<?php
  /**
   * latestTwitts Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2010
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  
  require_once ("oAuth.php");

  class TwitterException extends Exception
  {
      /**
       * TwitterException::__construct()
       * 
       * @param mixed $message
       * @return
       */
      public function __construct($message)
      {
          $args = func_get_args();

          parent::__construct(vsprintf($message, array_splice($args, 1)));
      }
  }
  
  class Twitts
  {

      const RequestTimelineMentions = '1.1/statuses/mentions_timeline';
      const RequestTimelineUser = '1.1/statuses/user_timeline';
      const RequestTimelineHome = '1.1/statuses/home_timeline';
      const RequestRetweetsOfMe = '1.1/statuses/retweets_of_me';
      const RequestRetweets = '1.1/statuses/retweets';
      const RequestTweet = '1.1/statuses/show';
      const RequestSearch = '1.1/search/tweets';
      const RequestFavorites = '1.1/favorites/list';

      const CountPerObject = 0;
      const CountTotal = 1;
      private static $MIN_PHP_VERSION = '5.3.0';

      private static $ERROR_PHP_VERSION = 'PHP version %s or greater required. Current version: %s';
      private static $ERROR_MODULE_REQUIRED = 'module %s required (and missing).';
      private static $ERROR_REQUIRED_OPTION = 'missing option required for request (%s)';
      private static $ERROR_UNSUPPORTED_MULTI_IDENTIFIER = 'unsupported option for multiple values (<em>%s</em>) for request type <em>%s</em>.';
      private static $ERROR_PRINT_FEED_UNSUPPORTED_REQUEST = 'unsupported request type for <code>->PrintFeed()</code> (<em>%s</em>).';
      private static $ERROR_TWITTER_RETURNED = 'the following errors were reported by Twitter - %s';

      private $classOptions = array();
      private $options = array();
      private $requestedData = null;
      private $loaded = false;
      private $defaultCount = 5;
    
      private $entityMap = array(
          'urls' => array(
              'option_flag' => 'detect_links',
              'format' => 'format_link',
              'prefix' => 'link'),
          'media' => array(
              'option_flag' => 'detect_links',
              'format' => 'format_media',
              'prefix' => 'media'),
          'user_mentions' => array(
              'option_flag' => 'detect_mentions',
              'format' => 'format_mention',
              'prefix' => 'mention'),
          'hashtags' => array(
              'option_flag' => 'detect_hashtags',
              'format' => 'format_hashtag',
              'prefix' => 'hashtag'));

      /**
       * latestTwitts::__construct()
       * 
       * @param mixed $opts
       * @return
       */
      public function __construct()
      {
          if (version_compare(PHP_VERSION, self::$MIN_PHP_VERSION) < 0)
              throw new TwitterException(self::$ERROR_PHP_VERSION, self::$MIN_PHP_VERSION, PHP_VERSION);

          if (!function_exists('curl_init'))
              throw new TwitterException(self::$ERROR_MODULE_REQUIRED, 'cURL');

          $this->getconfig();
          $this->options = array(
              'detect_links' => true,
              'detect_mentions' => true,
              'detect_hashtags' => true,
              'use_ssl' => true,
              'cache_life' => 3600,
              'request_type' => self::RequestTimelineUser,
              'count_mode' => self::CountTotal,
              'cache_dir' => BASEPATH . 'plugins/twitts/cache/',
              'format' => '{tweet:text}',
              'format_retweet' => '<li class="retweet">{tweet:text}</li>',
              'format_link' => '<a href="{link:expanded_url}" class="link-tweet">{link:url}</a>',
              'format_media' => '<a href="{media:expanded_url}" class="link-media">{media:url}</a>',
              'format_mention' => '<a href="http://twitter.com/{mention:screen_name}" title="View {mention:name}\'s Profile on Twitter" class="link-mention">@{mention:screen_name}</a>',
              'format_hashtag' => '<a href="http://twitter.com/#!/search?q={hashtag:text}" title="Search &#35;{hashtag:text} on Twitter" class="link-hashtag">#{hashtag:text}</a>',
              'relative_time_keywords' => array(
                  'second',
                  'minute',
                  'hour',
                  'day',
                  'week',
                  'month',
                  'year',
                  'decade'),
              'relative_time_plural_keywords' => array(
                  Lang::$word->_M_SECONDS,
                  Lang::$word->_M_MINUTES,
                  Lang::$word->_M_HOURS,
                  Lang::$word->_M_DAYS,
                  Lang::$word->_M_WEEKS,
                  Lang::$word->_MONTHS,
                  Lang::$word->_YEARS,
                  'decades'),
              'relative_time_prefix' => '',
              'relative_time_suffix' => Lang::$word->_AGO);

          $credentials = array(
              'screen_name' => $this->username,
              'consumer_key' => $this->consumer_key,
              'consumer_secret' => $this->consumer_secret,
              'user_token' => $this->access_token,
              'user_secret' => $this->access_secret,
              );

          $this->classOptions = array_keys($this->options);
          $this->options = array_merge($this->options, $credentials);

          $required = array(
              'consumer_key',
              'consumer_secret',
              'user_token',
              'user_secret');

          foreach ($required as $i => $opt) {
              if (self::option($opt) != null) {
                  unset($required[$i]);
              }
          }

          if (count($required) > 0)
              throw new TwitterException(self::$ERROR_REQUIRED_OPTION, implode(' and ', $required));

          self::setOption('user_agent', 'wk::cms');

          if (!file_exists(self::option('cache_dir')))
              mkdir(self::option('cache_dir'));
        
          mb_internal_encoding("UTF-8");
      }

      /**
       * latestTwitts::getconfig()
       * 
       * @return
       */
      private function getconfig()
      {

      $row = INI::read(PLUGPATH . 'twitts/config.ini');
      $this->username = $row->tw_config->username;
      $this->consumer_key = $row->tw_config->consumer_key;
      $this->consumer_secret = $row->tw_config->consumer_secret;
      $this->access_token = $row->tw_config->access_token;
      $this->access_secret = $row->tw_config->access_secret;
      $this->counter = $row->tw_config->counter;
      $this->speed = $row->tw_config->speed;
      $this->show_image = $row->tw_config->show_image;
      $this->timeout = $row->tw_config->timeout;
  
      return ($row) ? $row : 0;

      }

      /**
       * latestTwitts::processConfig()
       * 
       * @return
       */
      function processConfig()
      {

      Filter::checkPost('username', Lang::$word->_PLG_TW_USER);
      Filter::checkPost('counter', Lang::$word->_PLG_TW_COUNT);
      Filter::checkPost('consumer_key', Lang::$word->_PLG_TW_KEY);
      Filter::checkPost('consumer_secret', Lang::$word->_PLG_TW_SECRET);
      Filter::checkPost('access_token', Lang::$word->_PLG_TW_TOKEN);
      Filter::checkPost('access_secret', Lang::$word->_PLG_TW_TSECRET);

      if (empty(Filter::$msgs)) {
        $data = array('tw_config' => array(
            'username' => sanitize($_POST['username']),
            'consumer_key' => sanitize($_POST['consumer_key']),
            'consumer_secret' => sanitize($_POST['consumer_secret']),
            'access_token' => sanitize($_POST['access_token']),
            'access_secret' => sanitize($_POST['access_secret']),
            'counter' => intval($_POST['counter']),
            'speed' => intval($_POST['speed']),
            'show_image' => intval($_POST['show_image']),
            'timeout' => intval($_POST['timeout']),
            ));
  
        if (INI::write(PLUGPATH . 'twitts/config.ini', $data)) {
          $json['type'] = 'success';
          $json['message'] = Filter::msgOk(Lang::$word->_PLG_TW_UPDATED, false);
          Security::writeLog(Lang::$word->_PLG_TW_UPDATED, "", "no", "plugin");
        } else {
          $json['type'] = 'info';
          $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/plugins/twitts/config.ini}', false);
        }
        print json_encode($json);
  
      } else {
        $json['message'] = Filter::msgStatus();
        print json_encode($json);
      }
    }

      /**
       * latestTwitts::option()
       * 
       * @param mixed $name
       * @return
       */
      public function option($name)
      {
          return @$this->options[$name] ? : null;
      }

      /**
       * latestTwitts::setOption()
       * 
       * @param mixed $name
       * @param mixed $value
       * @return
       */
      public function setOption($name, $value)
      {
          $this->options[$name] = $value;
          $this->loaded = false;
      }

      /**
       * latestTwitts::GetRequestData()
       * 
       * @return
       */
      public function GetRequestData()
      {
          if (!self::isLoaded())
              self::loadRequest();

          return $this->requestedData;
      }

      /**
       * latestTwitts::PrintFeed()
       * 
       * @param mixed $callback
       * @return
       */
      public function PrintFeed($callback = null)
      {
          if (!self::isLoaded())
              self::loadRequest();

          $iterator = self::getRequestDataIterator();

          if (!isset($iterator) || !is_array($iterator))
              throw new TwitterException(self::$ERROR_PRINT_FEED_UNSUPPORTED_REQUEST, self::option('request_type'));

          $callable = is_callable($callback);


          $total = array();

          $max = self::option('count') ? : $this->counter;

          foreach ($iterator as $i => $tweet) {
              if (empty($tweet))
                  continue;

              if (self::option('count_mode') == self::CountPerObject) {
                  $user = $tweet[$tweet['is_retweet'] ? 'retweeter' : 'user']['screen_name'];

                  if (!isset($total[$user]))
                      $total[$user] = 1;
                  else
                      $total[$user]++;

                  if ($total[$user] > $max)
                      continue;
              } else
                  if ($i + 1 > $max) {
                      break;
                  }

              if ($callable)
                  call_user_func($callback, $tweet);
              else
                  echo self::formatString(self::option($tweet['is_retweet'] ? 'format_retweet' : 'format'), $tweet, 'tweet');
          }

      }

      /**
       * latestTwitts::renderTweets()
       * 
       * @param mixed $iterator
       * @return
       */
      private function renderTweets(&$iterator)
      {
          foreach ($iterator as $i => &$tweet) {
              if (empty($tweet))
                  continue;

              if (isset($tweet['retweeted_status'])) {
                  $user = $tweet['user'];
                  $tweet = $tweet['retweeted_status'];
                  $tweet['retweeter'] = $user;
                  $tweet['is_retweet'] = true;
              } else {
                  $tweet['is_retweet'] = false;
              }

              $tweet['original_text'] = $tweet['text'];
              $tweet['relative_time'] = self::relativeTime(strtotime($tweet['created_at']));
              $tweet['twitter_link'] = 'https://twitter.com/' . $tweet['user']['id_str'] . '/status/' . $tweet['id_str'];
              $tweet['tweet_index'] = $i;

              $entities = $tweet['entities'];

              $formatQueue = array();

              foreach ($entities as $type => $group) {
                  if (!isset($this->entityMap[$type]))
                      continue;

                  $map = $this->entityMap[$type];

                  if (self::option($map['option_flag'])) {
                      foreach ($group as $entity) {
                          $entity['format'] = self::formatString(self::option($map['format']), $entity, $map['prefix']);

                          $formatQueue[] = $entity;
                      }
                  }
              }

              usort($formatQueue, function ($a, $b)
              {
                  return $b['indices'][0] - $a['indices'][0]; }
              );

              foreach ($formatQueue as $entity) {
                  list($start, $end) = $entity['indices'];

                  $tweet['text'] = self::mbSubstringReplace($tweet['text'], $entity['format'], $start, $end - $start);
              }
          }

          self::sortTweets();
      }

      /**
       * latestTwitts::formatString()
       * 
       * @param mixed $input
       * @param mixed $obj
       * @param mixed $prefix
       * @return
       */
      public function formatString($input, $obj, $prefix)
      {
          return preg_replace_callback("/\{$prefix:([a-z-:0-9_]+)}/i", function ($match)use ($obj)
          {
              $dimensions = explode(':', $match[1]); 
        if (!isset($obj[$dimensions[0]]))return $match[0]; $replacement = $obj[$dimensions[0]]; 
        for ($i = 1; $i < count($dimensions); $i++) {
                  if (!isset($replacement[$dimensions[$i]])) {
          return $match[0]; 
          } else 
                  $replacement = $replacement[$dimensions[$i]]; 
          }

          return is_array($replacement) ? $match[0] : $replacement; 
      }
      , $input);
      }

    /**
     * latestTwitts::relativeTime()
     * 
     * @param mixed $timestamp
     * @return
     */
    private static function mbSubstringReplace($string, $replacement, $start, $length = null)
    {
      if ($length == null)
        return mb_substr($string, 0, $start) . $replacement;
    
      return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length);
    }
  
    /**
     * latestTwitts::relativeTime()
     * 
     * @param mixed $timestamp
     * @return
     */
    private function relativeTime($timestamp)
    {
      $difference = time() - $timestamp;
  
      $periods = array(self::option('relative_time_keywords'), self::option('relative_time_plural_keywords'));
  
      $lengths = array(
        60,
        60,
        24,
        7,
        4.35,
        12,
        10);
  
      for ($i = 0; $i < 7 && $difference >= $lengths[$i]; $i++)
        $difference /= $lengths[$i];
  
      $difference = round($difference);
  
      return implode(' ', array(
        self::option('relative_time_prefix'),
        $difference,
        $periods[($difference != 1) ? 1 : 0][$i],
        self::option('relative_time_suffix')));
    }
  
    /**
     * latestTwitts::loadRequest()
     * 
     * @return
     */
    private function loadRequest()
    {
      $auth = new tmhOAuth($this->options);
  
      if (self::cacheFileExists())
        self::cacheLoad($auth);
      else
        self::apiLoad($auth);
  
      self::renderTweets(self::getRequestDataIterator());
  
      $this->loaded = true;
    }
  
    /**
     * latestTwitts::getRequestDataIterator()
     * 
     * @return
     */
    private function &getRequestDataIterator()
    {
      switch (self::option('request_type')) {
        case self::RequestSearch:
          return $this->requestedData['statuses'];
          break;
        default:
          return $this->requestedData;
      }
    }
  
    /**
     * latestTwitts::sortTweets()
     * 
     * @return
     */
    private function sortTweets()
    {
      usort(self::getRequestDataIterator(), function ($a, $b)
      {
        if (empty($a) || empty($b))
        return 0; 
        return strtotime($b['created_at']) - strtotime($a['created_at']); 
      });
    }
  
    /**
     * latestTwitts::hasMultiIdentifiers()
     * 
     * @return
     */
    private function hasMultiIdentifiers()
    {
      $type = self::option('request_type');
  
      $supportedTypes = array(
        self::RequestTimelineUser,
        self::RequestRetweets,
        self::RequestTweet,
        self::RequestFavorites,
        self::RequestSearch);
  
      $supportsType = in_array($type, $supportedTypes);
  
      $identifier = self::cacheGetRequestIdentifier();
      $identifierValue = self::option($identifier);
  
      $is_array = is_array($identifierValue);
  
      if (!$supportsType && $is_array)
        throw new TwitterException(self::$ERROR_UNSUPPORTED_MULTI_IDENTIFIER, $identifier, $type);
  
      return $is_array;
    }
  
    /**
     * latestTwitts::isLoaded()
     * 
     * @return
     */
    private function isLoaded()
    {
      return $this->loaded;
    }
  
    /**
     * latestTwitts::apiLoad()
     * 
     * @param mixed $auth
     * @return
     */
    private function apiLoad($auth)
    {
      $identifier = self::cacheGetRequestIdentifier();
      $params = self::apiGetParams();
      $cache = array();
  
      $this->requestedData = array();
  
      if ($identifier == null) {
        $request = self::apiMakeRequest($auth, $params);
  
        $this->requestedData = $request;
  
        $cache = self::cacheWrapData($request);
      } else
        if (self::hasMultiIdentifiers()) {
          $identifiers = $params[$identifier];
  
          foreach ($identifiers as $id) {
            $params[$identifier] = $id;
  
            $request = self::apiMakeRequest($auth, $params)
              ;
  
            $this->requestedData = array_merge_recursive($this->requestedData, $request);
  
            $cache[strtolower($id)] = self::cacheWrapData($request);
          }
        } else {
          $request = self::apiMakeRequest($auth, $params);
  
          $this->requestedData = $request;
  
          $cache[strtolower($params[$identifier])] = self::cacheWrapData($request);
        }
  
        self::cacheSave($cache);
    }
  
    /**
     * latestTwitts::apiMakeRequest()
     * 
     * @param mixed $auth
     * @param mixed $params
     * @return
     */
    private function apiMakeRequest($auth, $params)
    {
      $auth->request('GET', $auth->url(self::option('request_type')), $params);
  
      $data = json_decode($auth->response['response'], true);
  
      if (isset($data['errors'])) {
        $errors = '';
  
        foreach ($data['errors'] as $error)
          $errors .= ' ' . $error['message'] . '; code ' . $error['code'] . '.';
  
        throw new TwitterException(self::$ERROR_TWITTER_RETURNED, $errors);
      }
  
      if (self::option('request_type') != self::RequestSearch && self::isArrayAssociative($data))
        $data = array($data);
  
      return $data;
    }
  
    /**
     * latestTwitts::apiGetParams()
     * 
     * @return
     */
    private function apiGetParams()
    {
      return array_diff_key($this->options, array_flip($this->classOptions));
    }
  
    /**
     * latestTwitts::cacheLoad()
     * 
     * @param mixed $auth
     * @return
     */
    private function cacheLoad($auth)
    {
      $cache = self::cacheMakeRequest();
      $params = self::apiGetParams();
      $identifier = self::cacheGetRequestIdentifier();
  
      if ($identifier == null) {
        if (self::cacheIsExpired($cache, null)) {
          $request = self::apiMakeRequest($auth, $params);
  
          $this->requestedData = $request;
  
          $cache = self::cacheWrapData($request);
  
          self::cacheSave($cache);
        } else {
          $this->requestedData = $cache['data'];
        }
      } else {
        if (self::hasMultiIdentifiers()) {
          list($identifiers, $changed) = array($params[$identifier], 0);
  
          $this->requestedData = array();
  
          foreach ($identifiers as $id) {
            $params[$identifier] = $id;
  
            if (self::cacheIsExpired($cache, $id)) {
              $changed++;
  
              $request = self::apiMakeRequest($auth, $params);
  
              $this->requestedData = array_merge_recursive($this->requestedData, $request);
  
              $cache[strtolower($id)] = self::cacheWrapData($request);
            } else {
              $this->requestedData = array_merge_recursive($this->requestedData, $cache[strtolower($id)]['data']);
            }
          }
  
          if ($changed > 0)
            self::cacheSave($cache);
        } else {
          if (self::cacheIsExpired($cache, $params[$identifier])) {
            $request = self::apiMakeRequest($auth, $params);
  
            $this->requestedData = $request;
  
            $cache[strtolower($params[$identifier])] = self::cacheWrapData($request);
  
            self::cacheSave($cache);
          } else {
            $this->requestedData = $cache[strtolower($params[$identifier])]['data'];
          }
        }
      }
    }
  
    /**
     * latestTwitts::cacheMakeRequest()
     * 
     * @return
     */
    private function cacheMakeRequest()
    {
      return json_decode(file_get_contents(self::cacheGetFileName()), true);
    }
  
    /**
     * latestTwitts::cacheSave()
     * 
     * @param mixed $data
     * @return
     */
    private function cacheSave($data)
    {
      file_put_contents(self::cacheGetFileName(), json_encode($data));
    }
  
    /**
     * latestTwitts::cacheWrapData()
     * 
     * @param mixed $data
     * @return
     */
    private function cacheWrapData($data)
    {
      return array('time' => time(), 'data' => $data);
    }
  
    /**
     * latestTwitts::cacheGetRequestIdentifier()
     * 
     * @return
     */
    private function cacheGetRequestIdentifier()
    {
      switch (self::option('request_type')) {
        case self::RequestTimelineUser:
        case self::RequestFavorites:
          $queue = array('screen_name', 'user_id');
  
          foreach ($queue as $i) {
            if (self::option($i) != null)
              return $i;
          }
  
          throw new TwitterException(self::$ERROR_REQUIRED_OPTION, implode(' or ', $queue));
          break;
        case self::RequestRetweets:
        case self::RequestTweet:
          if (self::option('id') == null)
            throw new TwitterException(self::$ERROR_REQUIRED_OPTION, 'id');
  
          return 'id';
        case self::RequestSearch:
          if (self::option('q') == null)
            throw new TwitterException(self::$ERROR_REQUIRED_OPTION, 'q');
  
          return 'q';
          break;
        default:
          return null;
      }
    }
  
    /**
     * latestTwitts::cacheFileExists()
     * 
     * @return
     */
    function cacheFileExists()
    {
      return file_exists(self::cacheGetFileName());
    }
  
    /**
     * latestTwitts::cacheIsExpired()
     * 
     * @param mixed $data
     * @param mixed $identifier
     * @return
     */
    private function cacheIsExpired($data, $identifier)
    {
      $obj = $identifier == null ? $data : @$data[strtolower($identifier)];
  
      return !isset($obj) || (time() - $obj['time'] >= self::option('cache_life'));
    }
  
    /**
     * latestTwitts::cacheGetFileName()
     * 
     * @return
     */
    private function cacheGetFileName()
    {
      return self::option('cache_dir') . preg_replace('/(\/|\\\)/', '-', self::option('screen_name')) . '.cache';
    }
  
    /**
     * latestTwitts::isArrayAssociative()
     * 
     * @param mixed $array
     * @return
     */
    private function isArrayAssociative($array)
    {
      return array_keys($array) !== range(0, count($array) - 1);
    }
  }
?>