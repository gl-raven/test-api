<?php

namespace Api;

use Mapper\ActionMapper;
use Mapper\GroupActionRelMapper;
use Mapper\UserMapper;
use PDO;

class User extends AbstractApi
{
    private UserMapper $userMapper;
    private GroupActionRelMapper $groupActionRelMapper;
    private ActionMapper $actionMapper;

    public function __construct()
    {
        parent::__construct();

        $this->userMapper = new UserMapper($this->db);
        $this->groupActionRelMapper = new GroupActionRelMapper($this->db);
        $this->actionMapper = new ActionMapper($this->db);
    }

    public function actionAccessRights(): void
    {
        $user_id = (int) $this->router->getParam(1);
        $user = $this->userMapper->findUser($user_id);

        if (!$user) {
            $this->response->setCode(404);
            $this->response->assign(['error' => 6]);
            return;
        }

        $user_rights = $this->groupActionRelMapper->getUserAccessRight($user_id);

        $rights = [];
        foreach ($this->actionMapper->getAllActions() as $action) {
            $rights[] = [
                $action['name'] => $user_rights[$action['id']] ?? false,
            ];
        }

        $this->response->assign($rights);
    }
}
