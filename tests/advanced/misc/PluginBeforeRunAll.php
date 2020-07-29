<?php
namespace tests\advanced\misc;

use extas\components\plugins\Plugin;
use extas\interfaces\stages\IStageBeforeRun;

/**
 * Class PluginBeforeRunAll
 *
 * @package tests\advanced\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginBeforeRunAll extends Plugin implements IStageBeforeRun
{
    /**
     * @param $object
     * @param mixed ...$methodArgs
     * @return array|string[]
     */
    public function __invoke($object, ...$methodArgs): array
    {
        list($source) = $methodArgs;
        $source .= '.before-run(all)';

        return [$source];
    }
}
