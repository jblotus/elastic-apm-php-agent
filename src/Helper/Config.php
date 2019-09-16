<?php

namespace PhilKra\Helper;

use PhilKra\Exception\MissingAppNameException;

/**
 *
 * Agent Config Store
 *
 */
class Config
{
    const ELASTIC_KEYWORD_MAX_LENGTH_DEFAULT = 1024;
    /**
     * Config Set
     *
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (isset($config['appName']) === false) {
            throw new MissingAppNameException();
        }

        // Register Merged Config
        $this->config = array_merge($this->getDefaultConfig(), $config);
    }

    /**
     * Get Config Value
     *
     * @param string $key
     *
     * @return mixed: value | null
     */
    public function get(string $key)
    {
        return ($this->config[$key]) ?? null;
    }

    /**
     * Get the all Config Set as array
     *
     * @return array
     */
    public function asArray() : array
    {
        return $this->config;
    }

    /**
     * Get the Default Config of the Agent
     *
     * @return array
     */
    private function getDefaultConfig() : array
    {
        return [
            'serverUrl'   => 'http://127.0.0.1:8200',
            'secretToken' => null,
            'hostname'    => gethostname(),
            'appVersion'  => '',
            'active'      => true,
            'timeout'     => 5,
            'apmVersion'  => 'v1',
            'env'         => [],
            // elastic apm indexes certain fields as keywords which default to length 1024
            // https://github.com/elastic/apm-server/issues/777#issuecomment-376517210
            // see
            // https://github.com/elastic/apm-server/blob/master/docs/spec/request.json
            'truncate'    => self::ELASTIC_KEYWORD_MAX_LENGTH_DEFAULT
        ];
    }
}
