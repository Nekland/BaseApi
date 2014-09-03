<?php

/**
 * This file is a part of nekland base api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\BaseApi\Http\Auth;


use Nekland\BaseApi\Http\AbstractHttpClient;

class AuthFactory
{
    /**
     * @var string[]
     */
    private $authentications;

    /**
     * @var string[]
     */
    private $namespaces;

    public function __construct()
    {
        $this->authentications = [];
        $this->namespaces      = [
            'Nekland\\BaseApi\\Http\\Auth\\'
        ];
    }

    /**
     * @param string $authName
     * @return AuthStrategyInterface
     * @throws \RuntimeException
     */
    public function get($authName)
    {
        if (isset($this->authentications[$authName])) {
            return new $this->authentications[$authName];
        }

        foreach ($this->namespaces as $namespace) {
            $authClass = $namespace . '\\' . $authName;

            if (class_exists($authClass)) {
                $auth = new $authClass();
                return $this->authentications[$authName] = $auth;
            }
        }

        throw new \RuntimeException(
            sprintf('The method "%s" is not supported for authentication.', $authName)
        );
    }

    /**
     * Add a new namespace for auth
     *
     * @param string $namespace
     */
    public function addNamespace($namespace)
    {
        $this->namespaces[] = $namespace;
    }

    /**
     * @param string $name
     * @param string $className
     * @return self
     */
    public function addAuth($name, $className)
    {
        $this->authentications[$name] = $className;

        return $this;
    }
}
