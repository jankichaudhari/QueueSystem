<?php
/**
 *
 */
class CitizenModel extends Model
{
    /**
     * @return array
     * @throws Exception
     */
    public function getTitles()
    {
        return $this->getEnumValues('citizen', 'title');
    }

    /**
     * @param $array
     * @return mixed
     */
    public function create($array)
    {
        return $this->doInsert('citizen', $array);
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
        $query = "SELECT CONCAT(title, ' ' , firstName, ' ', lastName) as fullname FROM citizen WHERE id = ?";
        $result = $this->fetchAssoc($query, [$id]);

        return $result['fullname'];
    }
}