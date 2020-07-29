<?php
namespace tests\advanced\misc;

use extas\components\Item;

/**
 * Class Dispatcher
 *
 * @package tests\advanced\misc
 * @author jeyroik <jeyroik@gmail.com>
 */
class Dispatcher extends Item
{
    /**
     * @param string $source
     * @return string
     */
    public function testMe(string $source): string
    {
        return $this->config['test'] . '.' . $source . '.tested';
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'dispatcher';
    }
}
