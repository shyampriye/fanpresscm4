<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\model\http;

/**
 * HTTP response handler object (incomplete!!!)
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2020, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @package fpcm\model\http
 * @since FPCm 4.4
 * @ignore
 */
final class response {

    /**
     * Response code
     * @var int
     */
    private $code = null;

    /**
     * Response headers
     * @var array
     */
    private $headers = [];

    /**
     * Response headers
     * @var array
     */
    private $returnData = null;

    /**
     * Set response code
     * @param int $code
     * @return $this
     */
    public function setCode(int $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Add response headers
     * @param string $header
     * @return $this
     */
    public function addHeaders(string $header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * Set return data
     * @param mixed $returnData
     * @return $this
     */
    public function setReturnData($returnData)
    {
        $this->returnData = $returnData;
        return $this;
    }

    /**
     * Fetch response result
     * @return bool
     */
    public function fetch()
    {
        if ($this->code !== null) {
            http_response_code($this->code);
        }

        if (count($this->headers)) {

            foreach ($this->headers as $header) {
                header($header);
            }

        }

        if ($this->returnData === null) {
            exit;
        }
        
        if (is_array($this->returnData) || is_object($this->returnData)) {
            $this->addHeaders('Content-Type: application/json');
            $this->returnData = json_encode($this->returnData);
        }

        exit($this->returnData);
    }


    
}