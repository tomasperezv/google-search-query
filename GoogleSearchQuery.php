<?php
/**
 * @author Tomás Pérez <tom@0x101.com>
 * @version 0.01
 * @see http://code.google.com/apis/ajaxsearch/documentation/
 */
class GoogleSearchQuery {

    private $apiKey = NULL;
    private $totalResultsCount = 0;
    private $curlClient = NULL;
    private $lastQueryUrl = NULL;

    const GOOGLE_SEARCH_API_BASE = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&";
    const GOOGLE_SEARCH_API_PARAMS = "q=QUERY&key=API_KEY&userip=USER_IP";

    /**
     * @param {String} $apiKey
     */
    public function  __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

   /**
    * @return {String}
    */
   public function getLastQueryUrl() {
       return $this->lastQueryUrl;
   }

   /**
    * @param {String} $req
    */
   public function search($req) {
       $req = urlencode($req);
       $query = self::GOOGLE_SEARCH_API_BASE.self::GOOGLE_SEARCH_API_PARAMS;
       $query = str_replace("QUERY", "\"$req\"", $query);
       $query = str_replace("API_KEY", $this->apiKey, $query);
       $query = str_replace("USER_IP", "82.158.253.161", $query);
       $this->lastQueryUrl = $query;
       $this->initCurl($this->lastQueryUrl);
   
       try {
           $data = curl_exec($this->curlClient);
           curl_close($this->curlClient);
       } catch(Exception $e) {
          echo PHP_EOL.$e->getMessage().PHP_EOL;
       }
       $json = json_decode($data);
       $this->totalResultsCount = $json->responseData->cursor->estimatedResultCount;
   }

   /**
    * @return {Integer} Total number of results
    */
   public function getTotalResultsCount() {
       return $this->totalResultsCount;
   }

   /**
    * @param {String} Url
    */
   public function initCurl($url) {
      try {
          $this->curlClient = curl_init();
          curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($this->curlClient, CURLOPT_REFERER, "http://127.0.0.1");
          curl_setopt($this->curlClient, CURLOPT_URL, $url);
      } catch(Exception $e) {
          echo PHP_EOL.$e->getMessage().PHP_EOL;
      }
   }
}
