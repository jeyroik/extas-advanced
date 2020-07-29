<?php
namespace tests\advanced;

use Dotenv\Dotenv;
use extas\components\Item;
use extas\components\plugins\TSnuffPlugins;
use extas\components\THasWatchableClass;
use extas\interfaces\IHasClass;
use extas\interfaces\stages\IStageAfterBuild;
use extas\interfaces\stages\IStageAfterRun;
use extas\interfaces\stages\IStageBeforeBuild;
use extas\interfaces\stages\IStageBeforeRun;
use PHPUnit\Framework\TestCase;
use tests\advanced\misc\Dispatcher;
use tests\advanced\misc\PluginAfterBuildAll;
use tests\advanced\misc\PluginAfterBuildPersonal;
use tests\advanced\misc\PluginAfterRunAll;
use tests\advanced\misc\PluginAfterRunPersonal;
use tests\advanced\misc\PluginBeforeBuildAll;
use tests\advanced\misc\PluginBeforeBuildPersonal;
use tests\advanced\misc\PluginBeforeRunAll;
use tests\advanced\misc\PluginBeforeRunPersonal;

/**
 * Class HasClassTest
 *
 * @package tests\advanced
 * @author jeyroik <jeyroik@gmail.com>
 */
class HasClassTest extends TestCase
{
    use TSnuffPlugins;

    public function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
    }

    protected function tearDown(): void
    {
        $this->deleteSnuffPlugins();
    }

    public function testBasic()
    {
        $item = new class ([
            IHasClass::FIELD__CLASS => Dispatcher::class
        ]) extends Item {
            use THasWatchableClass;

            protected function getSubjectForExtension(): string
            {
                return 'test';
            }
        };

        $this->createSnuffPlugin(PluginBeforeBuildAll::class, [IStageBeforeBuild::NAME__ALL]);
        $this->createSnuffPlugin(PluginBeforeBuildPersonal::class, [IStageBeforeBuild::NAME . Dispatcher::class]);
        $this->createSnuffPlugin(PluginAfterBuildAll::class, [IStageAfterBuild::NAME__ALL]);
        $this->createSnuffPlugin(PluginAfterBuildPersonal::class, [IStageAfterBuild::NAME . Dispatcher::class]);
        $this->createSnuffPlugin(
            PluginBeforeRunAll::class,
            [IStageBeforeRun::NAME . 'dispatcher' . IStageBeforeRun::NAME__ALL]
        );
        $this->createSnuffPlugin(
            PluginBeforeRunPersonal::class,
            [IStageBeforeRun::NAME . 'dispatcher' . '.testMe']
        );
        $this->createSnuffPlugin(
            PluginAfterRunPersonal::class,
            [IStageAfterRun::NAME . 'dispatcher' . '.testMe']
        );
        $this->createSnuffPlugin(
            PluginAfterRunAll::class,
            [IStageAfterRun::NAME . 'dispatcher' . IStageAfterRun::NAME__ALL]
        );

        $result = $item->runWithParameters(['test' => 'ok'], 'testMe', 'arg1');

        $this->assertEquals(
            'ok.before(all).before(personal).after(personal).after(all).' .
            'arg1.before-run(all).before-run(personal).tested.after-run(personal).after-run(all)',
            $result,
            'Incorrect: ' . $result
        );
    }
}
