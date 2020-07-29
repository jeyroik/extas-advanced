<?php
namespace tests\advanced\misc;

use extas\components\plugins\Plugin;
use extas\interfaces\stages\IStageAfterBuild;

/**
 * Class PluginAfterBuildAll
 *
 * @package tests\advanced\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginAfterBuildAll extends Plugin implements IStageAfterBuild
{
    /**
     * @param $object
     * @return object
     */
    public function __invoke($object): object
    {
        $object['test'] = $object['test'] . '.after(all)';

        return $object;
    }
}
