<?php


namespace Mapper;


use PDO;

class GroupActionRelMapper extends AbstractMapper
{
    public function getUserAccessRight($user_id): array
    {
        $query = 'SELECT
                        a_rel.action_id as action_id, min(a_rel.access) as access
                    FROM
                    `group_action_rel` as a_rel 
                    INNER JOIN
                    `user_group_rel` as `g_rel` on a_rel.`group_id` = `g_rel`.`group_id`
                    WHERE
                    `user_id` = :user_id
                    GROUP BY
                        a_rel.action_id
                    ;
            ';
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            ':user_id' => $user_id,
        ));

        $user_rights = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user_rights[$row['action_id']] = (bool) $row['access'];
        }

        return $user_rights;
    }
}
