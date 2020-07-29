<?php
namespace extas\interfaces\stages;

/**
 * Interface IStageAfterBuild
 *
 * @package extas\interfaces\stages
 * @author jeyroik <jeyroik@gmail.com>
 */
interface IStageAfterBuild
{
    public const NAME = 'extas.after.build.';
    public const NAME__ALL = self::NAME . '@classes';

    /**
     * @param $object
     * @return object
     */
    public function __invoke($object): object;
}
