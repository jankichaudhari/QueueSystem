<?php

class CustomerModel extends Model
{

	const CUSTOMER_CITIZEN = 'citizen';
	const CUSTOMER_ORGANISATION = 'organisation';
	const CUSTOMER_ANONYMOUS = 'anonymous';

    public $organisation = ['name'];
    public $fields = ['custTypeId', 'custInfoId', 'serviceId'];

    /**
     * @param bool|false $withInfo
     * @return array
     */
    public function listTypes($withInfo = false)
    {
        $types = [];
        $query = 'SELECT id, type FROM customertype';

        //retrieve only types which has more information stored in database
        //for example citizen and organisation
        if($withInfo) {
            $query .= " WHERE hasInfo = $withInfo";
        }

        $result = $this->fetchArray($query);
        foreach ($result as $key => $value) {
            $types[$value['id']] = $value['type'];
        }

        return $types;
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getType($id)
    {
        if (!$id) {
            throw new Exception("Invalid Argument!");
        }

        $id = $this->escapeString($id);
        $query = 'SELECT type FROM customertype WHERE id = ?';

        $result = $this->fetchAssoc($query, [$id]);

        return $result['type'];
    }

    /**
     * @param $array
     * @return mixed
     */
    public function create($array)
    {
        return $this->doInsert('customer', $array);
    }

    /**
     * @return mixed
     */
    public function listCustomers()
    {
        $query = "SELECT * FROM customer ORDER BY updated ASC";

        return $this->fetchArray($query);
    }
}

?>
