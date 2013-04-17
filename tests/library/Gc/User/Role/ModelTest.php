<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category Gc_Tests
 * @package  Library
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Gc\User\Role;

use Gc\Registry;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:08.
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group Gc
 * @category Gc_Tests
 * @package  Library
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Model
     *
     * @return void
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->object = Model::fromId(1);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::save
     *
     * @return void
     */
    public function testSave()
    {
        $permissions = $this->object->getUserPermissions();
        $array       = array();
        foreach ($permissions as $typeName => $typeValues) {
            $array += $typeValues;
        }

        $this->object->setPermissions($array);
        $this->assertInternalType('integer', (int) $this->object->save());
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::save
     *
     * @return void
     */
    public function testSaveWithoutId()
    {
        $model = new Model();
        $model->setName('New Name2');
        $model->setDescription('Test description2');

        $this->assertInternalType('integer', (int) $model->save());
        $model->delete();
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::save
     *
     * @return void
     */
    public function testSaveWithWrongValues()
    {
        /**
         * Mysql does not generate exception
         */
        $configuration = Registry::get('Configuration');
        if ($configuration['db']['driver'] == 'pdo_mysql') {
            return;
        }

        $this->setExpectedException('\Gc\Exception');
        $model = new Model();
        $model->setId('undefined');
        $this->assertFalse($model->save());
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::delete
     * @covers Gc\User\Role\Model::save
     *
     * @return void
     */
    public function testDelete()
    {
        $model = new Model();
        $model->setName('New Name');
        $model->setDescription('Test description');
        $model->save();
        $this->assertTrue($model->delete());
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::delete
     *
     * @return void
     */
    public function testFakeDelete()
    {
        $model = new Model();
        $this->assertFalse($model->delete());
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::fromArray
     *
     * @return void
     */
    public function testFromArray()
    {
        $this->assertInstanceOf('Gc\User\Role\Model', Model::fromArray($this->object->getData()));
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::fromId
     *
     * @return void
     */
    public function testFromId()
    {
        $this->assertInstanceOf('Gc\User\Role\Model', Model::fromId(1));
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::fromId
     *
     * @return void
     */
    public function testFromFakeId()
    {
        $this->assertFalse(Model::fromId(42));
    }

    /**
     * Test
     *
     * @covers Gc\User\Role\Model::getUserPermissions
     *
     * @return void
     */
    public function testGetUserPermissions()
    {
        $this->assertInternalType('array', $this->object->getUserPermissions());
    }
}
