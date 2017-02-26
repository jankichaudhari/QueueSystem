<?php
/**
 *
 */
class ServiceModel extends Model
{
    /**
     * @param int $typeId
     * @return array
     */
    public function listServicesByType($typeId = 2)
    {
        $typeId = $this->escapeString($typeId);
        $services = [];
        $params = [];
        $query = 'SELECT id, name FROM services';

        if(!is_null($typeId)) {
            $query .= ' WHERE custTypeId = ?';
            $params[] = $typeId;
        }

        $result = $this->fetchArray($query, $params);
        foreach($result as $key=>$value) {
            $services[$value['id']] = $value['name'];
        }

        return $services;
    }

    /**
     * @return array
     */
    public function listServices()
    {
        $services = [];
        $query = 'SELECT id, name FROM services';


        $result = $this->fetchArray($query);
        foreach($result as $key=>$value) {
            $services[$value['id']] = $value['name'];
        }

        return $services;
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getName($id)
    {
        if (!$id) {
            throw new Exception("Invalid Argument!");
        }

        $id = $this->escapeString($id);
        $query = 'SELECT name FROM services WHERE id = ?';

        $result = $this->fetchAssoc($query, [$id]);

        return $result['name'];
    }
}