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
 * @package  ZfModules
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */

namespace Config\Controller;

use Gc\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Gc\User\Model as UserModel;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-15 at 23:50:57.
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group    ZfModules
 * @category Gc_Tests
 * @package  ZfModules
 */
class UserControllerTest extends AbstractHttpControllerTestCase
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $this->init();
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::indexAction
     *
     * @return void
     */
    public function testIndexAction()
    {
        $this->dispatch('/admin/config/user/list');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userList');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::loginAction
     *
     * @return void
     */
    public function testLoginAction()
    {
        $this->dispatch('/admin/user/login');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userlogin');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::loginAction
     *
     * @return void
     */
    public function testLoginActionWithPostData()
    {
        $this->dispatch(
            '/admin/user/login',
            'POST',
            array(
                'login' => $this->user->getLogin(),
                'password' => 'test-user-model-password'
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userLogin');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::loginAction
     *
     * @return void
     */
    public function testLoginActionWithPostAndRedirectData()
    {
        $this->dispatch(
            '/admin/user/login/L2FkbWlu',
            'POST',
            array(
                'login' => $this->user->getLogin(),
                'password' => 'test-user-model-password',
                'redirect' => 'L2FkbWlu'
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userLogin');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::loginAction
     *
     * @return void
     */
    public function testLoginActionWithWrongPostData()
    {
        $this->dispatch(
            '/admin/user/login/L2FkbWlu',
            'POST',
            array(
                'login' => 'testlogin',
                'password' => 'passwordtest',
                'redirect' => 'L2FkbWlu'
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userLogin');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::forgotPasswordAction
     *
     * @return void
     */
    public function testForgotPasswordAction()
    {
        $this->dispatch('/admin/config/user/forgot-password');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userForgotPassword');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::forgotPasswordAction
     *
     * @return void
     */
    public function testForgotPasswordActionWithPostData()
    {
        $userModel = UserModel::fromArray(
            array(
                'lastname' => 'Test',
                'firstname' => 'Test',
                'email' => 'pierre.rambaud86@gmail.com',
                'login' => 'testlogin',
                'user_acl_role_id' => 1,
            )
        );
        $userModel->setPassword('passwordtest');
        $userModel->save();

        $this->dispatch(
            '/admin/config/user/forgot-password',
            'POST',
            array(
                'email' => 'pierre.rambaud86@gmail.com'
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userForgotPassword');

        $userModel->delete();
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::forgotPasswordAction
     *
     * @return void
     */
    public function testForgotPasswordActionWithInvalidPostData()
    {
        $this->dispatch(
            '/admin/config/user/forgot-password',
            'POST',
            array(
                'email' => 'pierre.rambaud'
            )
        );
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userForgotPassword');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::logoutAction
     *
     * @return void
     */
    public function testLogoutAction()
    {
        $this->dispatch('/admin/user/logout');
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userLogout');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::createAction
     *
     * @return void
     */
    public function testCreateAction()
    {
        $this->dispatch('/admin/config/user/create');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userCreate');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::createAction
     *
     * @return void
     */
    public function testCreateActionWithWrongPostData()
    {
        $this->dispatch(
            '/admin/config/user/create',
            'POST',
            array(
            )
        );
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userCreate');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::createAction
     *
     * @return void
     */
    public function testCreateActionWithPostData()
    {
        $this->dispatch(
            '/admin/config/user/create',
            'POST',
            array(
                'email' => 'pierre.rambaud86@gmail.com',
                'firstname' => 'azdazd',
                'lastname' => 'azdazd',
                'login' => 'dazd',
                'password' => 'azdazd',
                'password_confirm' => 'azdazd',
                'user_acl_role_id' => 3,
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userCreate');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::deleteAction
     *
     * @return void
     */
    public function testDeleteAction()
    {
        $userModel = UserModel::fromArray(
            array(
                'lastname' => 'Test',
                'firstname' => 'Test',
                'email' => 'test@got-cms.com',
                'login' => 'testlogin',
                'user_acl_role_id' => 2,
            )
        );
        $userModel->setPassword('passwordtest');
        $userModel->save();

        $this->dispatch('/admin/config/user/delete/' . $userModel->getId());
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userDelete');

        $userModel->delete();
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::deleteAction
     *
     * @return void
     */
    public function testDeleteActionWithWrongId()
    {
        $this->dispatch('/admin/config/user/delete/9999');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userDelete');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::editAction
     *
     * @return void
     */
    public function testEditActionWithWrongId()
    {
        $this->dispatch('/admin/config/user/edit/9999');
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userEdit');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::editAction
     *
     * @return void
     */
    public function testEditAction()
    {
        $this->dispatch('/admin/config/user/edit/' . $this->user->getId());
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userEdit');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::editAction
     *
     * @return void
     */
    public function testEditActionWithInvalidPostData()
    {
        $this->dispatch(
            '/admin/config/user/edit/' . $this->user->getId(),
            'POST',
            array(
            )
        );
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userEdit');
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::editAction
     *
     * @return void
     */
    public function testEditActionWithPostData()
    {
        $userModel = UserModel::fromArray(
            array(
                'lastname' => 'Test',
                'firstname' => 'Test',
                'email' => 'pierre.rambaud86@got-cms.com',
                'login' => 'testlogin',
                'user_acl_role_id' => 2,
            )
        );
        $userModel->setPassword('passwordtest');
        $userModel->save();

        $this->dispatch(
            '/admin/config/user/edit/' . $userModel->getId(),
            'POST',
            array(
                'lastname' => 'Test',
                'firstname' => 'Test',
                'email' => 'pierre.rambaud86@got-cms.com',
                'login' => 'testlogin',
                'user_acl_role_id' => 2,
                'password' => 'test',
                'password_confirm' => 'test',
            )
        );
        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userEdit');

        $userModel->delete();
    }

    /**
     * Test
     *
     * @covers Config\Controller\UserController::forbiddenAction
     *
     * @return void
     */
    public function testForbiddenAction()
    {
        $this->dispatch('/admin/user/forbidden-access');
        $this->assertResponseStatusCode(403);

        $this->assertModuleName('Config');
        $this->assertControllerName('UserController');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('userForbidden');
    }
}
