<?php

namespace TanSandbox\JsonRest;

/**
 * Basic json response builder.
 *
 * This is something you will achieve.
 * eg:
 *   {
 *      "status": false,
 *       "data": {
 *           "name": "Nithin",
 *           "subject": "English",
 *           "mark": "90"
 *       },
 *       "message": "Action completed"
 *   }
 *
 * Json response builder for zend framework 2. You can choose "ok()", "fail()" or "send()" method to return response.
 * ok() : will return data with 200 OK.
 * fail (): will return data with 500 Server Error.
 * send() : you can set custom http status code using setStatus method.
 * 
 * All methods begin with "set" can be chained together.
 * It is allowed to call magic set function eg: setMyCustomVariable("My Value") is possible.
 *   $json->setSubject("English")->setMark("10")->ok() ;
 * 
 * Note: A status field will be auto appended depending on the status code. Status true will be used if status belongs to 2xx code. Otherwise a false is returned.
 * The ok() will append a status "true" and "false" for fail method.
 *
 * @author nithin ta
 * @link https://github.com/tansandbox/zend-rest-json
 */
class Builder
{
    /**
     * Holds addition json data.
     * 
     * @var array
     */
    private $extra = [] ;
    /**
     * ZF request object.
     * 
     * @var unknown
     */
    private $request = null ;
    /**
     * ZF Response object.
     * 
     * @var unknown
     */
    private $response = null ;
    /**
     * Track last response type. eg: true for ok(), and false for fail()
     * 
     * @var string
     */
    private $lastStatus = null ;

    /**
     * Name for status field in response.
     *
     * @var string
     */
    private $statusField = 'status' ;
    /**
     * Name for main data set in response.
     * 
     * @var string
     */
    private $dataField = 'data' ;
    /**
     * Name for main message set in response.
     * 
     * @var string
     */
    private $messageField = 'message' ;

    /**
     * Set HTTP code for your json response.
     * 
     * @param unknown $code
     * @return \Restful\Controller\RestfulController
     */
    public function setStatus($code) {
        $this->lastStatus = $code ;
        return $this ;
    }
    /**
     * Retrieve current http status code in use.
     * 
     * @param unknown $code
     * @return string current status code in use.
     */
    public function getStatus($code) {
        return $this->lastStatus ;        
    }    
    /**
     * Magic methods prefixed with "set" are handled and inserted into return data collection.
     * 
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractController::__call()
     */
    public function __call( $method, $args ) {
        if( stripos($method, "set") === 0 ) {
            $key = str_replace('set', '', $method) ;

            if( strtolower($key) !== 'data' ) {

                if( ! empty($args) ) {
                    $value = $args[0] ;

                    $this->extra[lcfirst($key)] = $value ;

                    return $this ;
                }
            }
            else {
                trigger_error('To set data please use one of the following method ok(), fail, send() or sendie().', E_USER_ERROR) ;                
                return null ;
            }
        }

        trigger_error('Call to undefined method ' . __CLASS__ . '::' . $method . '()', E_USER_ERROR) ;
        return null ;
    }
    /**
     * Return json array formed till now.
     *
     * @param unknown $data
     * @return array
     */
    public function get($data = null)
    {
        /* If data is not sent vai ok/fail then status is calculated via http status.*/
        if( $this->lastStatus === null ) {
            $code = 200 ;
            $codePrefix = substr( (string)$code, 0,1 ) ;
            $status = ($codePrefix == '2') ? true : false ;
        }
        else {
            $status = $this->lastStatus ;
        }
        
        //put status
        $resp = array() ;
        $resp[ $this->statusField ] = $status ;
        
        //put optional data
        if( $data !== null) {
            $resp[$this->dataField] = $data ;
        }
        
        //put extras..
        foreach( $this->extra as $k => $v ) {
            $resp[$k] = $v ;
        }
        
        return $resp ;
    }
    /**
     * Output formatted json to browser.
     * 
     * @param unknown $data
     * @return bool true always
     */
    public function send($data = null)
    {
        $jdata = $this->get($data) ; 
        header('Content-type: application/json') ;
        http_response_code($this->lastStatus) ;
        echo json_encode($jdata) ;
        return true ;
    }
    /**
     * Output formatted json to browser and stop processing.
     * 
     * @param unknown $data
     */
    public function sendie($data = null)
    {
        $this->send();
        die;
    }
    /**
     * Add a message to the response json.
     * 
     * @param unknown $msg
     * @return \ZendRestJson\Json\Json
     */
    public function setMessage( $msg ) {
        $this->extra[$this->messageField] = $msg ;
        return $this ;
    }
    /**
     * Get the value set for message field.
     * 
     * @return mixed
     */
    public function getMessage() {
        return $this->extra[$this->messageField] ;
    }
    /**
     * Return output with HTTP 200 OK.
     * 
     * @param array $data
     * @return bool true always
     */
    public function ok($data = null)
    {
        $this->lastStatus = true ;
        $this->setStatus(200)->send($data) ;
        return true ;
    }
    /**
     * Return output with HTTP 500 Server Er
     * 
     * @param array $data
     * @return bool true always
     */
    public function fail($data = null)
    {
        $this->lastStatus = false ;
        $this->setStatus(500)->send($data) ;
        return true ;
    }
}