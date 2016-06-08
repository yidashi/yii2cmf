<?php

namespace jamband\schemadump\tests;

use Yii;
use jamband\schemadump\SchemaDumpController;
use jamband\schemadump\tests\StdOutBufferControllerTrait;
use jamband\schemadump\tests\DatabaseOperationsTrait;

class SchemaDumpControllerTest extends TestCase
{
    private $controller;

    protected function setUp()
    {
        parent::setUp();

        $this->mockApplication([
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ],
            ],
        ]);

        $module = $this->getMock('yii\\base\\Module', ['fake'], ['console']);
        $this->controller = new SchemaDumpControllerMock('schemadump', $module);
    }

    public function testActionCreate()
    {
    }

    public function testActionDrop()
    {
    }

     /**
     * Emulates running of the schemadump controller action.
     * @param string $actionID id of action to be run.
     * @param array  $args action arguments.
     * @return string command output.
     */
    private function runAction($actionID, array $args = [])
    {
        $this->controller->run($actionID, $args);
        return $this->controller->flushStdOutBuffer();
    }
}

class SchemaDumpControllerMock extends SchemaDumpController
{
    use StdOutBufferControllerTrait;
    use DatabaseOperationsTrait;
}
