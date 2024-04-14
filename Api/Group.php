<?php


namespace Api;


use Core\Request;
use Mapper\GroupMapper;
use Mapper\UserGroupRelMapper;
use Mapper\UserMapper;
use PDO;

class Group extends AbstractApi
{
    private GroupMapper $groupMapper;
    private UserMapper $userMapper;
    private UserGroupRelMapper $userGroupRelMapper;

    public function __construct()
    {
        parent::__construct();

        $this->groupMapper = new GroupMapper($this->db);
        $this->userMapper = new UserMapper($this->db);
        $this->userGroupRelMapper = new UserGroupRelMapper($this->db);
    }


    /**
     * Добавление пользователя в группу
     */
    public function actionAddUser(): void
    {
        $group_id = (int) $this->router->getParam(1);
        $group = $this->groupMapper->findGroup($group_id);
        if (!$group) {
            $this->response->setCode(404);
            $this->response->assign(['error' => 3]);
            return;
        }

        $user_id = (int) $this->request->get('user_id', Request::POST);
        $user = $this->userMapper->findUser($user_id);
        if (empty($user)) {
            $this->response->setCode(400);
            $this->response->assign(['error' => 4]);
            return;
        }

        $rel = $this->userGroupRelMapper->getUserGroupRel($group_id, $user_id);

        if (empty($rel)) {
            $this->userGroupRelMapper->createRel($group_id, $user_id);
        }

        $this->response->setCode(201);
        $this->response->assign(['success' => '1']);
    }

    /**
     * Удаление пользователя из группы
     */
    public function actionDeleteUser(): void
    {
        $group_id = (int) $this->router->getParam(1);
        $group = $this->groupMapper->findGroup($group_id);
        if (!$group) {
            $this->response->setCode(404);
            $this->response->assign(['error' => 1]);
            return;
        }

        $user_id = (int) $this->request->get('user_id', Request::DELETE);
        $user = $this->userMapper->findUser($user_id);
        if (empty($user)) {
            $this->response->setCode(400);
            $this->response->assign(['error' => 2]);
            return;
        }

        $rel = $this->userGroupRelMapper->getUserGroupRel($group_id, $user_id);
        if (!empty($rel)) {
            $this->userGroupRelMapper->deleteRel($rel['id']);
        }

        $this->response->assign(['success' => '1']);
    }

    /**
     * Вывод списка пользователей группы
     */
    public function actionListUsers(): void
    {
        $group_id = (int) $this->router->getParam(1);
        $group = $this->groupMapper->findGroup($group_id);
        if (!$group) {
            $this->response->setCode(404);
            $this->response->assign(['error' => 5]);
            return;
        }

        $this->response->assign($this->userMapper->getUsersInGroup($group_id));
    }
}
