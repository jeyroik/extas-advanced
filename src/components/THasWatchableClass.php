<?php
namespace extas\components;

use extas\interfaces\IHasClass;
use extas\interfaces\IItem;
use extas\interfaces\stages\IStageAfterBuild;
use extas\interfaces\stages\IStageAfterRun;
use extas\interfaces\stages\IStageBeforeBuild;
use extas\interfaces\stages\IStageBeforeRun;

/**
 * Trait THasWatchableClass
 *
 * @property $config
 * @method getPluginsByStage(string $stage, array $parameters = [])
 *
 * @package extas\components
 * @author jeyroik@gmail.com
 */
trait THasWatchableClass
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->config[IHasClass::FIELD__CLASS] ?? '';
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setClass(string $class)
    {
        $this->config[IHasClass::FIELD__CLASS] = $class;

        return $this;
    }

    /**
     * @param array $parameters
     *
     * @return mixed
     */
    public function buildClassWithParameters(array $parameters = [])
    {
        $className = $this->getClass();

        foreach ($this->getPluginsByStage(IStageBeforeBuild::NAME__ALL) as $plugin) {
            /**
             * @var IStageBeforeBuild $plugin
             */
            $parameters = $plugin($parameters);
        }

        foreach ($this->getPluginsByStage(IStageBeforeBuild::NAME . $className) as $plugin) {
            /**
             * @var IStageBeforeBuild $plugin
             */
            $parameters = $plugin($parameters);
        }

        $object = new $className($parameters);

        foreach ($this->getPluginsByStage(IStageAfterBuild::NAME . $className) as $plugin) {
            /**
             * @var IStageAfterBuild $plugin
             */
            $object = $plugin($object);
        }

        foreach ($this->getPluginsByStage(IStageAfterBuild::NAME__ALL) as $plugin) {
            /**
             * @var IStageAfterBuild $plugin
             */
            $object = $plugin($object);
        }

        return $object;
    }

    /**
     * @param array $constructConfig
     * @param string $method
     * @param mixed ...$methodArgs
     * @return mixed
     */
    public function runWithParameters(array $constructConfig, string $method, ...$methodArgs)
    {
        $dispatcher = $this->buildClassWithParameters($constructConfig);
        $subject = $dispatcher instanceof IItem ? $dispatcher->__subject() : get_class($dispatcher);

        $stage = IStageBeforeRun::NAME . $subject . IStageBeforeRun::NAME__ALL;
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $methodArgs = $plugin($dispatcher, ...$methodArgs);
        }

        $stage = IStageBeforeRun::NAME . $subject . '.' . $method;
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $methodArgs = $plugin($dispatcher, ...$methodArgs);
        }

        $result = $dispatcher->$method(...$methodArgs);

        $stage = IStageAfterRun::NAME . $subject . '.' . $method;
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $result = $plugin($result, $dispatcher, ...$methodArgs);
        }

        $stage = IStageAfterRun::NAME . $subject . IStageAfterRun::NAME__ALL;
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $result = $plugin($result, $dispatcher, ...$methodArgs);
        }

        return $result;
    }
}
