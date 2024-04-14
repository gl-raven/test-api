<?php


namespace Mapper;


use PDO;

class UserGroupRelMapper extends AbstractMapper
{
    public function getUserGroupRel(int $group_id, int $user_id): array|false
    {
        $query = 'SELECT * FROM `user_group_rel` WHERE `user_id` = :user_id AND `group_id` = :group_id LIMIT 1';

        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            ':group_id' => $group_id,
            ':user_id' => $user_id,
        ));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRel(int $group_id, int $user_id): void
    {
        $query = 'INSERT INTO `user_group_rel` (`user_id`, `group_id`) VALUES (:user_id, :group_id)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":group_id", $group_id);
        $stmt->execute();
    }

    public function deleteRel(int $id): void
    {
        $query = 'DELETE FROM `user_group_rel` WHERE `id` = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }
}
