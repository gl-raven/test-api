<?php


namespace Mapper;


use PDO;

class GroupMapper extends AbstractMapper
{
    /**
     * @param int $id
     * @return array|false
     */
    public function findGroup(int $id): array|false
    {
        $query = 'SELECT * FROM `user_group` WHERE `id` = :id LIMIT 1';

        $stmt = $this->db->prepare($query);
        $stmt->execute(array(
            ':id' => $id,
        ));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
