<?php
namespace tests\advanced\misc;

use extas\components\plugins\Plugin;
use extas\interfaces\stages\IStageAfterBuild;

/**
 * Class PluginAfterBuildPersonal
 *
 * @package tests\advanced\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginAfterBuildPersonal extends Plugin implements IStageAfterBuild
{
    public function __invoke($object): object
    {
        $object['test'] = $object['test'] . '.after(personal)';

        return $object;
    }
}
