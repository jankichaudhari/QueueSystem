<?php
/**
 *
 */
class OrganisationModel extends Model
{
    /**
     * @param $array
     * @return mixed
     */
    public function create($array)
    {
        return $this->doInsert('organisation', $array);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getFullName($id)
    {
        if (!$id) {
            throw new Exception("Invalid Argument!");
        }

        $id = $this->escapeString($id);
        $query = "SELECT name FROM organisation WHERE id = ?";

        $result = $this->fetchAssoc($query, [$id]);

        return $result['name'];
    }
}