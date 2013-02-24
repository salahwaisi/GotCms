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

namespace Gc\Media;

use Gc\Document\Model as DocumentModel;
use Gc\Property\Model as PropertyModel;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:09.
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group Gc
 * @category Gc_Tests
 * @package  Library
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var File
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new File;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $_FILES = array();
    }

    /**
     * @covers Gc\Media\File::load
     */
    public function testInit()
    {
        $property = PropertyModel::fromArray(
            array(
                'id' => 1
            )
        );
        $document = DocumentModel::fromArray(
            array(
                'id' => 1
            )
        );
        $this->assertNull($this->object->load($property, $document, 1));
    }

    /**
     * @covers Gc\Media\File::getPath
     */
    public function testGetPath()
    {
        $this->assertEquals(realpath(GC_MEDIA_PATH . '/..'), $this->object->getPath());
    }

    /**
     * @covers Gc\Media\File::getDirectory
     */
    public function testGetDirectory()
    {
        $property = PropertyModel::fromArray(
            array(
                'id' => 1
            )
        );
        $document = DocumentModel::fromArray(
            array(
                'id' => 1
            )
        );
        $this->object->load($property, $document);

        $this->assertEquals(
            '/media/files/' . $document->getId() . '/' . $property->getId(),
            $this->object->getDirectory()
        );
    }

    /**
     * @covers Gc\Media\File::getFileTransfer
     */
    public function testGetFileTransfer()
    {
        $this->assertInstanceOf('Zend\File\Transfer\Adapter\Http', $this->object->getFileTransfer());
    }

    /**
     * @covers Gc\Media\File::upload
     */
    public function testUpload()
    {
        $this->initializeFiles();
        $_FILES = array();
        $result = $this->object->upload();
        $this->removeDirectories();
        $this->assertFalse($result);
    }

    /**
     * @covers Gc\Media\File::upload
     * @covers Gc\Media\File::remove
     */
    public function testUploadWithoutValidators()
    {
        $this->initializeFiles();

        $this->object->getFileTransfer()->removeValidator('Zend\Validator\File\Upload');
        $result = $this->object->upload();
        $this->assertTrue($this->object->upload());

        $files = $this->object->getFiles();
        if (is_array($files)) {
            foreach ($files as $file) {
                $this->object->remove($file->filename);
            }
        }

        $this->removeDirectories();
        $this->assertTrue($result);
    }

    /**
     * @covers Gc\Media\File::remove
     */
    public function testRemove()
    {
        $this->assertTrue($this->object->remove('undefined-file'));
    }

    /**
     * @covers Gc\Media\File::copyDirectory
     */
    public function testCopyDirectory()
    {
        $source = __DIR__ . '/_files/copy/source';
        $destination = __DIR__ . '/_files/copy/destination';
        $this->assertTrue($this->object->copyDirectory($source, $destination));
        `rm -rf $destination`;
    }

    /**
     * @covers Gc\Media\File::isWritable
     */
    public function testIsWritable()
    {
        $directory = __DIR__ . '/_files/copy';
        $this->assertTrue($this->object->isWritable($directory));
    }

    /**
     * @covers Gc\Media\File::isWritable
     */
    public function testIsWritableWithNotWritablePath()
    {
        $this->assertFalse($this->object->isWritable('/etc'));
    }

    protected function initializeFiles()
    {
        $_FILES = array(
            'test' => array(
                'name' => __DIR__ . '/_files/test.jpg',
                'type' => 'plain/text',
                'size' => 8,
                'tmp_name' => __DIR__ . '/_files/test.jpg',
                'error' => 0
            )
        );

        $property = PropertyModel::fromArray(
            array(
                'id' => 'test-upload'
            )
        );
        $document = DocumentModel::fromArray(
            array(
                'id' => 'test-upload'
            )
        );

        $this->object->load($property, $document, 'test');
    }

    protected function removeDirectories()
    {
        $dir = $this->object->getPath() . $this->object->getDirectory();
        if (is_dir($dir)) {
            $data = glob($dir . '/*');
            foreach ($data as $file) {
                unlink($file);
            }

            $tmp_dir = $dir;
            while ($tmp_dir != GC_MEDIA_PATH . '/files') {
                rmdir($tmp_dir);
                $tmp_dir = realpath(dirname($tmp_dir));
            }
        }
    }
}
