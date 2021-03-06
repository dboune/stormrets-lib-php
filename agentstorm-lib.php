<?php

/*
    Copyright 2009-2012 StormRETS Inc (email : info@stormrets.com)

    ---

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
    ---
    
    Some parts of this code based on code by JanRain, The Yadis Library is
    available at http://github.com/openid/php-openid/tree/master/Auth/Yadis/
    
*/

define('AGENT_STORM_USER_AGENT', 'agentstorm-lib-php/1.0');

#define('AGENT_STORM_VERIFY_HOST', true);

/**
 * The AgentStormException class represents exceptions raised.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormException extends Exception
{}


/**
 * The AgentStormFilter interface represents classes used to specify result filters.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
interface AgentStormFilter {
    public function toString();
}

/**
 * The AgentStormFilter_Limit interface specifies a filter to limit the result.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_Limit implements AgentStormFilter {
    
    public $limit;
    
    function __construct($limit) {
        $this->limit = $limit;
    }
    
    function toString() {
        return sprintf("limit=%s", urlencode($this->limit));
        return '&limit=' . urlencode($this->limit); 
    }
    
}
    
/**
 * The AgentStormFilter_Range interface specifies a filter based a range.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_Range implements AgentStormFilter {
    
    public $field;
    
    public $min;
    
    public $max;
    
    function __construct($field, $min, $max) {
        $this->field = $field;
        $this->min = $min;
        $this->max = $max;
    }
    
    function toString() {
        return sprintf("%s=%s:%s", urlencode($this->field), urlencode($this->min), urlencode($this->max));
    }
    
}
    
/**
 * The AgentStormFilter_Offset interface specifies a filter based a offset.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_Offset implements AgentStormFilter {
    
    public $offset;
    
    function __construct($offset) {
        $this->offset = $offset;
    }
    
    function toString() {
        return sprintf("offset=%s", urlencode($this->offset));
    }
    
}

/**
 * The AgentStormFilter_Sort class specifies a filter on sort the query.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_Sort implements AgentStormFilter {
    
    
    public $field;
    
    public $direction;
    
    
    const SORT_DIRECTION_ASCENDING = 'ASC';
    
    const SORT_DIRECTION_DESCENDING = 'DESC';
    
    
    function __construct($field, $directon) {
        $this->field = $field;
        $this->direction = $directon;
    }
    
    function toString() {
        return sprintf("sort=%s&sort_direction=%s", urlencode($this->field), urlencode($this->direction));
    }
    
}
    
/**
 * The AgentStormFilter_LessThan class specifies a filter to query a field with a LessThan operator.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_LessThan implements AgentStormFilter {
    
    public $field;
    
    public $value;
    
    function __construct($field, $value) {
        $this->field = $field;
        $this->value = $value;
    }
    
    function toString() {
        return sprintf("%s=%s-", urlencode($this->field), urlencode($this->value));
    }
    
}

/**
 * The AgentStormFilter_GreaterThan class specifies a filter to query a field with a GreaterThan operator.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_GreaterThan implements AgentStormFilter {
    
    public $field;
    
    public $value;
    
    function __construct($field, $value) {
        $this->field = $field;
        $this->value = $value;
    }
    
    function toString() {
        return sprintf("%s=%s+", urlencode($this->field), urlencode($this->value));
    }
    
}

/**
 * The AgentStormFilter_Equals class specifies a filter to query a field with an Equals operator.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_Equals implements AgentStormFilter {
    
    public $field;
    
    public $value;
    
    function __construct($field, $value) {
        $this->field = $field;
        $this->value = $value;
    }
    
    function toString() {
        return sprintf("%s=%s", urlencode($this->field), urlencode($this->value));
    }
    
}
    
/**
 * The AgentStormFilter_In class specifies a filter to query a field where the value is equal to one of the passed array items.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_In implements AgentStormFilter {
    
    public $field;
    
    public $value;
    
    function __construct($field, $value) {
        $this->field = $field;
        $this->value = $value;
    }
    
    function toString() {
        return sprintf("%s=%s", urlencode($this->field), urlencode(join(',', $this->value)));
    }
    
}

/**
 * The AgentStormFilter_View class specifies a filter to query a field where the value is equal to one of the passed array items.
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormFilter_View {
    
    function __construct($view) {
        throw new Exception('AgentStormFilter_View is Depreciated');
    }
    
}

/**
 * The AgentStormFilter_ZipCodeProximity class specifies a filter to query properties within a zip code radius
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 * @depreciated
 */
class AgentStormFilter_ZipCodeProximity implements AgentStormFilter {
    
    const METRIC_KM = 'km';
    
    const METRIC_MILES = 'm';
    
    public $field;
    
    public $zipcode;
    
    public $proximity;
    
    public $metric;
    
    function __construct($field, $zipcode, $proximity, $metric) {
        $this->field = $field;
        $this->zipcode = $zipcode;
        $this->proximity = $proximity;
        $this->metric = $metric;
    }
    
    function toString() {
        return sprintf("coord=ZipCode:%s:%s:%s", urlencode($this->zipcode), urlencode($this->proximity), urlencode($this->metric));
    }
    
}

/**
 * The AgentStormHTTPResponse implements a received HTTP response
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/) some parts Copyright (c) JanRain Inc.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormHTTPResponse {
    function __construct(
        $final_url = null,
        $status = null,
        $headers = null,
        $body = null
    ) {
        $this->final_url = $final_url;
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
    }
}

/**
 * The AgentStormHTTPFetcher implements basic HTTP Fetcher functionality
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/) some parts Copyright (c) JanRain Inc.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormHTTPFetcher {
    
    var $timeout = 20;

    /**
     * Return whether a URL can be fetched.  Returns false if the URL
     * scheme is not allowed or is not supported by this fetcher
     * implementation; returns true otherwise.
     *
     * @return bool
     */
    function canFetchURL($url) {
        
        if ($this->isHTTPS($url) && !$this->supportsSSL()) {
            return false;
        }
        
        if (!$this->allowedURL($url)) {
            return false;
        }
        
        return true;
    }

    /**
     * Return whether a URL should be allowed. Override this method to
     * conform to your local policy.
     *
     * By default, will attempt to fetch any http or https URL.
     */
    function allowedURL($url) {
        return $this->URLHasAllowedScheme($url);
    }

    /**
     * Does this fetcher implementation (and runtime) support fetching
     * HTTPS URLs?  May inspect the runtime environment.
     *
     * @return bool $support True if this fetcher supports HTTPS
     * fetching; false if not.
     */
    function supportsSSL() {
        trigger_error("not implemented", E_USER_ERROR);
    }

    /**
     * Is this an https URL?
     *
     * @access private
     */
    function isHTTPS($url) {
        return (bool)preg_match('/^https:\/\//i', $url);
    }

    /**
     * Is this an http or https URL?
     *
     * @access private
     */
    function URLHasAllowedScheme($url) {
        return (bool)preg_match('/^https?:\/\//i', $url);
    }

    /**
     * @access private
     */
    function _findRedirect($headers, $url) {
        foreach ($headers as $line) {
            if (strpos(strtolower($line), "location: ") === 0) {
                $parts = explode(" ", $line, 2);
                $loc = $parts[1];
                $ppos = strpos($loc, "://");
                if ($ppos === false || $ppos > strpos($loc, "/")) {
                  /* no host; add it */
                  $hpos = strpos($url, "://");
                  $prt = substr($url, 0, $hpos+3);
                  $url = substr($url, $hpos+3);
                  if (substr($loc, 0, 1) == "/") {
                    /* absolute path */
                    $fspos = strpos($url, "/");
                    if ($fspos) $loc = $prt.substr($url, 0, $fspos).$loc;
                    else $loc = $prt.$url.$loc;
                  } else {
                    /* relative path */
                    $pp = $prt;
                    while (1) {
                      $xpos = strpos($url, "/");
                      if ($xpos === false) break;
                      $apos = strpos($url, "?");
                      if ($apos !== false && $apos < $xpos) break;
                      $apos = strpos($url, "&");
                      if ($apos !== false && $apos < $xpos) break;
                      $pp .= substr($url, 0, $xpos+1);
                      $url = substr($url, $xpos+1);
                    }
                    $loc = $pp.$loc;
                  }
                }
                return $loc;
            }
        }
        return null;
    }

    /**
     * Fetches the specified URL using optional extra headers and
     * returns the server's response.
     *
     * @param string $url The URL to be fetched.
     * @param array $extra_headers An array of header strings
     * (e.g. "Accept: text/html").
     * @return mixed $result An array of ($code, $url, $headers,
     * $body) if the URL could be fetched; null if the URL does not
     * pass the URLHasAllowedScheme check or if the server's response
     * is malformed.
     */
    function get($url, $headers = null) {
        trigger_error("not implemented", E_USER_ERROR);
    }
    
}

/**
 * The AgentStormParanoidHTTPFetcher forms a base for all Agent Storm API Endpoints and 
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/) some parts Copyright (c) JanRain Inc.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormParanoidHTTPFetcher extends AgentStormHTTPFetcher {
    
    function __construct() {
        $this->reset();
    }

    function reset() {
        $this->headers = array();
        $this->data = "";
    }

    /**
     * @access private
     */
    function _writeHeader($ch, $header) {
        array_push($this->headers, rtrim($header));
        return strlen($header);
    }

    /**
     * @access private
     */
    function _writeData($ch, $data) {
        if (strlen($this->data) > 1024*1024) {
            return 0;
        } else {
            $this->data .= $data;
            return strlen($data);
        }
    }

    /**
     * Does this fetcher support SSL URLs?
     */
    function supportsSSL() {
        $v = curl_version();
        if(is_array($v)) {
            return in_array('https', $v['protocols']);
        } elseif (is_string($v)) {
            return preg_match('/OpenSSL/i', $v);
        } else {
            return 0;
        }
    }

    function get($url, $extra_headers = null) {
        if (!$this->canFetchURL($url)) {
            return null;
        }
        
        $stop = time() + $this->timeout;
        $off = $this->timeout;
        
        $redir = true;
        
        while ($redir && ($off > 0)) {
            $this->reset();
            
            $c = curl_init();
            
            if ($c === false) {
                return null;
            }
            
            if (defined('CURLOPT_NOSIGNAL')) {
                curl_setopt($c, CURLOPT_NOSIGNAL, true);
            }
            
            if (!$this->allowedURL($url)) {
                return null;
            }
            
            curl_setopt($c, CURLOPT_WRITEFUNCTION,
                        array($this, "_writeData"));
            curl_setopt($c, CURLOPT_HEADERFUNCTION,
                        array($this, "_writeHeader"));
            
            if ($extra_headers) {
                curl_setopt($c, CURLOPT_HTTPHEADER, $extra_headers);
            }
            
            $cv = curl_version();
            if(is_array($cv)) {
              $curl_user_agent = 'curl/'.$cv['version'];
            } else {
              $curl_user_agent = $cv;
            }
            curl_setopt($c, CURLOPT_USERAGENT,
                        AGENT_STORM_USER_AGENT.' '.$curl_user_agent);
            curl_setopt($c, CURLOPT_TIMEOUT, $off);
            curl_setopt($c, CURLOPT_URL, $url);
            
            if (defined('AGENT_STORM_VERIFY_HOST')) {
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
            }
            curl_exec($c);
            
            $code = curl_getinfo($c, CURLINFO_HTTP_CODE);
            $body = $this->data;
            $headers = $this->headers;
            
            if (!$code) {
                return null;
            }
            
            if (in_array($code, array(301, 302, 303, 307))) {
                $url = $this->_findRedirect($headers, $url);
                $redir = true;
            } else {
                $redir = false;
                curl_close($c);
                
                $new_headers = array();
                
                foreach ($headers as $header) {
                    if (strpos($header, ': ')) {
                        list($name, $value) = explode(': ', $header, 2);
                        $new_headers[$name] = $value;
                    }
                }
                
                return new AgentStormHTTPResponse($url, $code, $new_headers, $body);
            }
            
            $off = $stop - time();
        }
        
        return null;
        
    }

    function post($url, $body, $extra_headers = null) {
        if (!$this->canFetchURL($url)) {
            return null;
        }
        
        $this->reset();
        
        $c = curl_init();
        
        if (defined('CURLOPT_NOSIGNAL')) {
            curl_setopt($c, CURLOPT_NOSIGNAL, true);
        }
        
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $body);
        curl_setopt($c, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_WRITEFUNCTION,
                    array($this, "_writeData"));
        
        if (defined('AGENT_STORM_VERIFY_HOST')) {
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
        }
        
        curl_exec($c);
        
        $code = curl_getinfo($c, CURLINFO_HTTP_CODE);
        
        if (!$code) {
            return null;
        }
        
        $body = $this->data;
        
        curl_close($c);
        
        $new_headers = $extra_headers;
        
        foreach ($this->headers as $header) {
            if (strpos($header, ': ')) {
                list($name, $value) = explode(': ', $header, 2);
                $new_headers[$name] = $value;
            }
            
        }
        
        return new AgentStormHTTPResponse($url, $code, $new_headers, $body);
    }    
}

/**
 * The AgentStormRequest forms a base for all Agent Storm API Endpoints and 
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
abstract class AgentStormRequest {
    
    /**
     * The API Key to use when communicating with the AgentStorm Service
     */
    private $api_key = '';
    
    /**
     * The Agent Storm subdomain
     */
    private $sub_domain = '';
    
    /**
     * The Service endpoint
     */
    private $service_url = '';
    
    /**
     * Whether to parse the return data or return as-is.
     */
    private $raw_mode = false;
    
    /**
     * The fomat of the results
     */
    protected $format = '';
    
    /**
     *
     */
    function __construct($sub_domain, $api_key, $format='json', $raw_mode = false) {
        $this->sub_domain = $sub_domain;
        $this->api_key = $api_key;
        $this->format = $format;
        $this->raw_mode = $raw_mode;
    }
    
    
    /**
     *
     */
    protected function request($end_point, $filters) {
        
        $http = new AgentStormParanoidHTTPFetcher();
        
        $url = sprintf('http://%s.stormrets.com%s?apikey=%s&%s', $this->sub_domain, $end_point, $this->api_key, $this->build_querystring_from_filters($filters));
        $response = $http->get($url);
        
        if ($response) {
            if ($this->raw_mode == true) {
                return $response->body;
            } else {
                return json_decode($response->body);
            }
            break;
        }
        
    }
    
    /**
     * Builds the querystring based on the passed filters
     */
    private function build_querystring_from_filters($filters = array()) {
        
        //$qs = sprintf('apikey=%s', $this->api_key);
        $qs = '';
        foreach ($filters as $item) {
            $qs .= '&' . $item->toString();
        }
        return trim($qs, '&');
        
    }
    
}

/**
 * The AgentStormEndpoint base class for providing common endpoint functions
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormEndpoint extends AgentStormRequest {
    
    protected $end_point = '';
    
    /**
     *
     */
    function __construct($sub_domain, $apikey, $end_point, $format = 'json', $raw_mode = false) {
        parent::__construct($sub_domain, $apikey, $format, $raw_mode);
        $this->end_point = $end_point;
    }
    
    /**
     * Get all the contacts from offset to limit
     */
    public function getAll($offset = 0, $limit = 20) {
        return $this->request(sprintf('/%s.%s', $this->end_point, $this->format), array(
            new AgentStormFilter_Offset($offset),
            new AgentStormFilter_Limit($limit)
        ));
    }
    
    /**
     * Get the Contact with the specified Id
     */
    public function getById($id) {
        return $this->request(sprintf('/%s/%s.%s', $this->end_point, $id, $this->format), array());
    }
    
    /**
     *
     */
    public function search($filters = array()) {
        return $this->request(sprintf('/%s.%s', $this->end_point, $this->format), $filters, $this->format);
    }
    
}

/**
 * The AgentStormEndpoint base class for providing common endpoint functions
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormContactsEndpoint extends AgentStormEndpoint {
    function __construct($sub_domain, $apikey, $format = 'json', $raw_mode = false) {
        parent::__construct($sub_domain, $apikey, 'contacts', $format, $raw_mode);
    }
}

/**
 * The AgentStormEndpoint base class for providing common endpoint functions
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormCompaniesEndpoint extends AgentStormEndpoint {
    function __construct($sub_domain, $apikey, $format = 'json', $raw_mode = false) {
        parent::__construct($sub_domain, $apikey, 'companies', $format, $raw_mode);
    }
}

/**
 * The AgentStormEndpoint base class for providing common endpoint functions
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormUserEndpoint extends AgentStormEndpoint {
    
    const ROLE_NONE = 0;
    
    const ROLE_AGENT = 10;
    
    const ROLE_BROKER = 20;
    
    const ROLE_CONTRACTOR = 30;
    
    const ROLE_PHOTOGRAPHER = 40;
    
    const ROLE_HOMESTAGER = 50;
    
    const ROLE_INSURANCEAGENT = 60;
    
    function __construct($sub_domain, $apikey, $format = 'json', $raw_mode = false) {
        parent::__construct($sub_domain, $apikey, 'users', $format, $raw_mode);
    }
}

/**
 * The AgentStormEndpoint base class for providing common endpoint functions
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormPropertiesEndpoint extends AgentStormEndpoint {
    
    function __construct($sub_domain, $apikey, $format = 'json', $raw_mode = false) {
        parent::__construct($sub_domain, $apikey, 'properties', $format, $raw_mode);
    }
    
    /**
     * Cities Endpoint
     */
    public function getCities() {
        return $this->request(sprintf('/%s/cities.%s', $this->end_point, $this->format), array());
    }
    
    /**
     * Get All Tags
     */
    public function getTags() {
        return $this->request(sprintf('/%s/tags.%s', $this->end_point, $this->format), array());
    }
    
    /**
     * Get Properties tagged with $tag
     */
    public function getByTag($tag, $filters = array()) {
        return $this->request(sprintf('/%s/tags/%s.%s', $this->end_point, $tag, $this->format), $filters);
    }
    
}

/**
 * The AgentStormEndpoint base class for providing common endpoint functions
 *
 * @copyright  Copyright (c) StormRETS Inc (http://www.stormrets.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class AgentStormPropertyTourEndpoint extends AgentStormEndpoint {
    
    function __construct($sub_domain, $apikey, $format = 'json', $raw_mode = false) {
        parent::__construct($sub_domain, $apikey, 'properties/media/virtualtours', $format, $raw_mode);
    }
    
}


?>