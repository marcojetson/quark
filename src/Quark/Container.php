<?php
/*
 * This file is part of the Quark package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Quark;

/**
 * A service container
 *
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 */
class Container
{
    /** @var callable[] */
    private $factories = [];

    /** @var bool[] */
    private $share = [];

    /** @var mixed[] */
    private $shared = [];

    /**
     * @param string $id
     * @param callable $factory
     */
    public function set($id, callable $factory)
    {
        $this->register($id, $factory, false);
    }

    /**
     * @param string $id
     * @param callable $factory
     */
    public function share($id, callable $factory)
    {
        $this->register($id, $factory, true);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function __get($id)
    {
        return $this->get($id);
    }

    /**
     * @param string $id
     * @param mixed $arguments
     * @return mixed
     */
    public function __call($id, $arguments)
    {
        return $this->get($id, $arguments);
    }

    /**
     * @param string $id
     * @param callable $factory
     * @param bool $share
     */
    private function register($id, callable $factory, $share)
    {
        $this->factories[$id] = $factory;
        $this->share[$id] = $share;
    }

    /**
     * @param string $id
     * @param array $arguments
     * @return mixed
     * @throws \InvalidArgumentException
     */
    private function get($id, array $arguments = [])
    {
        if (!isset($this->factories[$id])) {
            throw new \InvalidArgumentException(sprintf('Service %s not found', $id));
        }

        if (!$this->share[$id]) {
            return $this->factories[$id](...$arguments);
        }

        if (!isset($this->shared[$id])) {
            $this->shared[$id] = $this->factories[$id](...$arguments);
        }

        return $this->shared[$id];
    }
}
