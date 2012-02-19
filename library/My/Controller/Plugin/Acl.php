<?php

class My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $acl = new Zend_Acl();
        // add the roles

        $rolesModel = new Model_Role();
        $roles = $rolesModel->fetchAll();
        foreach ($roles as $row) {
            $acl->addRole($row['name']);
        }

        $resourceModel = new Model_Resource();
        $resources = $resourceModel->fetchAll();
        foreach ($resources as $row) {
            $acl->addResource($row['name']);
        }

        //$acl->addRole(new Zend_Acl_Role('user'), 'guest');//user inhert from guest
        //$acl->addRole(new Zend_Acl_Role('admin'), 'user');
        // add the resources
        /*
          $acl->addResource(new Zend_Acl_Resource('index'));
          $acl->add(new Zend_Acl_Resource('error'));
          $acl->add(new Zend_Acl_Resource('page'));
          $acl->add(new Zend_Acl_Resource('menu'));
          $acl->add(new Zend_Acl_Resource('menuitem'));
          $acl->add(new Zend_Acl_Resource('user/index'));
          $acl->add(new Zend_Acl_Resource('user/admin'));
          $acl->add(new Zend_Acl_Resource('content/admin'));
          $acl->add(new Zend_Acl_Resource('content/index'));
         * 
         */
        $rolesResourceModel = new Model_Roleresources();
        $data = $rolesResourceModel->fetchAll();
        foreach ($data as $row) {
            $acl->allow($rolesModel->getRoleName($row->role_id), $resourceModel->getResourceName($row->resource_id));
        }
        /*
          $acl->allow(null, array('index', 'error'));
          // a guest can only read content and login
          $acl->allow('guest', 'page', array('index', 'open'));
          $acl->allow('guest', 'menu', array('render'));
          $acl->allow('guest', 'user/index', array('login'));
          // cms users can also work with content
          $acl->allow('user', 'page', array('list', 'create', 'edit', 'delete'));
          // administrators can do anything
          $acl->allow('admin', null);
          // fetch the current user
         * 
         */
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $role = $rolesModel->getRoleName($identity->role_id);
        } else {
            $role = $rolesModel->getDefaultRole();
        }
        $controller = $request->controller;
        $module = $request->module;
        $action = $request->action;

        $resource = $module . '/' . $controller . '/' . $action;
        if (!$acl->has($resource)) {
            if ($controller == 'admin') {
                $resource = 'admin';
            } else {
                $resource = 'index';
            }
        }
        if (!$acl->isAllowed($role, $resource, $action)) {
            if ($role == 'guest') {
                $request->setModuleName('user');
                $request->setControllerName('index');
                $request->setActionName('login');
            } else {
                $request->setModuleName('user');
                $request->setControllerName('index');
                $request->setActionName('noauth');
            }
        }
    }

}

?>