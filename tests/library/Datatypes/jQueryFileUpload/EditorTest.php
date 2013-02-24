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
 * @package  Datatypes
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Datatypes\jQueryFileUpload;

use Gc\Datatype\Model as DatatypeModel;
use Gc\DocumentType\Model as DocumentTypeModel;
use Gc\Document\Model as DocumentModel;
use Gc\Layout\Model as LayoutModel;
use Gc\Property\Model as PropertyModel;
use Gc\User\Model as UserModel;
use Gc\Tab\Model as TabModel;
use Gc\View\Model as ViewModel;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:42:12.
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group Datatypes
 * @category Gc_Tests
 * @package  Datatypes
 */
class EditorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Editor
     */
    protected $object;

    /**
     * @var DatatypeModel
     */
    protected $datatype;

    /**
     * @var PropertyModel
     */
    protected $property;

    /**
     * @var ViewModel
     */
    protected $view;

    /**
     * @var LayoutModel
     */
    protected $layout;

    /**
     * @var TabModel
     */
    protected $tab;

    /**
     * @var UserModel
     */
    protected $user;

    /**
     * @var DocumentTypeModel
     */
     protected $documentType;

    /**
     * @var DocumentModel
     */
     protected $document;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->view = ViewModel::fromArray(
            array(
                'name' => 'View Name',
                'identifier' => 'View identifier',
                'description' => 'View Description',
                'content' => 'View Content'
            )
        );
        $this->view->save();

        $this->layout = LayoutModel::fromArray(
            array(
                'name' => 'Layout Name',
                'identifier' => 'Layout identifier',
                'description' => 'Layout Description',
                'content' => 'Layout Content'
            )
        );
        $this->layout->save();

        $this->user = UserModel::fromArray(
            array(
                'lastname' => 'User test',
                'firstname' => 'User test',
                'email' => 'test@test.com',
                'login' => 'test',
                'user_acl_role_id' => 1,
            )
        );
        $this->user->setPassword('test');
        $this->user->save();

        $this->documentType = DocumentTypeModel::fromArray(
            array(
                'name' => 'Document Type Name',
                'description' => 'Document Type description',
                'icon_id' => 1,
                'defaultview_id' => $this->view->getId(),
                'user_id' => $this->user->getId(),
            )
        );
        $this->documentType->save();

        $this->datatype = DatatypeModel::fromArray(
            array(
                'name' => 'jQueryFileUploadTest',
                'prevalue_value' => '',
                'model' => 'jQueryFileUpload',
            )
        );
        $this->datatype->save();

        $this->tab = TabModel::fromArray(
            array(
                'name' => 'TabTest',
                'description' => 'TabTest',
                'sort_order' => 1,
                'document_type_id' => $this->documentType->getId(),
            )
        );
        $this->tab->save();

        $this->property = PropertyModel::fromArray(
            array(
                'name' => 'DatatypeTest',
                'identifier' => 'DatatypeTest',
                'description' => 'DatatypeTest',
                'required' => false,
                'sort_order' => 1,
                'tab_id' => $this->tab->getId(),
                'datatype_id' => $this->datatype->getId(),
            )
        );
        $this->property->save();

        $this->document = DocumentModel::fromArray(
            array(
                'name' => 'jQueryFileUploadTest',
                'url_key' => '/jqueryfileupload-test',
                'status' => DocumentModel::STATUS_ENABLE,
                'sort_order' => 1,
                'show_in_nav' => false,
                'user_id' => $this->user->getId(),
                'document_type_id' => $this->documentType->getId(),
                'view_id' => $this->view->getId(),
                'layout_id' => $this->layout->getId(),
                'parent_id' => 0,
            )
        );
        $this->document->save();

        $datatype = new Datatype();
        $datatype->load($this->datatype, $this->document->getId());
        $this->object = $datatype->getEditor($this->property);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $_FILES = array();
        $_POST = array();
        $this->datatype->delete();
        $this->documentType->delete();
        $this->document->delete();
        $this->layout->delete();
        $this->property->delete();
        $this->tab->delete();
        $this->user->delete();
        $this->view->delete();

        unset($this->datatype);
        unset($this->documentType);
        unset($this->document);
        unset($this->layout);
        unset($this->property);
        unset($this->tab);
        unset($this->user);
        unset($this->view);
        unset($this->object);
    }

    /**
     * @covers Datatypes\jQueryFileUpload\Editor::save
     */
    public function testSave()
    {
        copy(__DIR__ . '/_files/test-source.bmp', __DIR__ . '/_files/test.bmp');
        $this->object->getRequest()->getPost()->set(
            $this->object->getName(),
            array(
                array(
                    'name' => '',
                ),
                array(
                    'name' => '../tests/library/Datatypes/jQueryFileUpload/_files/test.jpg',
                ),
                array(
                    'name' => '../tests/library/Datatypes/jQueryFileUpload/_files/test.bmp',
                ),
            )
        );

        $this->object->setConfig(
            array(
                'is_multiple' => true,
                'mime_list' => array(
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                )
            )
        );

        $this->object->save();
        $result = $this->object->getValue();

        $this->assertInternalType('string', $this->object->getValue());
    }

    /**
     * @covers Datatypes\jQueryFileUpload\Editor::load
     * @covers Datatypes\jQueryFileUpload\Editor::initScript
     */
    public function testLoad()
    {
        $this->object->setValue(
            serialize(
                array(
                    array(
                        'value' => __DIR__ . '/_files/test.jpg',
                    )
                )
            )
        );
        $this->assertInternalType('string', $this->object->load());
    }
}
