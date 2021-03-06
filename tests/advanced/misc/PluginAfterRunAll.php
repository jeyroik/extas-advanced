<?php
namespace tests\advanced\misc;

use extas\components\plugins\Plugin;
use extas\interfaces\stages\IStageAfterRun;

/**
 * Class PluginAfterRunAll
 *
 * @package tests\advanced\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginAfterRunAll extends Plugin implements IStageAfterRun
{
    /**
     * @param $result
     * @param $object
     * @param mixed ...$methodArgs
     * @return mixed|string
     */
    public function __invoke($result, $object, ...$methodArgs)
    {
        return $result .= '.after-run(all)';
    }
}
