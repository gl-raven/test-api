<?php

namespace Mapper;


use PDO;

class UserMapper extends AbstractMapper
{
    public function findUser($user_id): array|false
    {
        $query = 'SELECT * FROM `user` WHERE `id` = :id LIMIT 1';
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            ':id' => $user_id,
        ));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function getUsersInGroup(int $group_id): array
    {
        $query = 'SELECT `user`.* 
                    FROM 
                         `user` 
                    INNER JOIN `user_group_rel` as `rel` on `rel`.`user_id` = `user`.`id`
                    WHERE
                        `rel`.`group_id` = :group_id;';
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            ':group_id' => $group_id,
        ));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
