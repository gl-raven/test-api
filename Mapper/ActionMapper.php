<?php


namespace Mapper;


use PDO;

class ActionMapper extends AbstractMapper
{
    public function getAllActions()
    {
        $query = 'SELECT * FROM `action`';
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
