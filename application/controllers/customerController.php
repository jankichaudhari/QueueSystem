<?php
/**
 ** Handles Customers pages
 */
class CustomerController extends controller
{
    /** @var CustomerModel $customerModel */
    public $customerModel;
    
    /** @var ServiceModel $serviceModel */
    public $serviceModel;

    /** @var CitizenModel $citizenModel */
    public $citizenModel;

    /** @var OrganisationModel $organisationModel */
    public $organisationModel;

    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        //initialize models
        $this->customerModel = $this->loadModel('customer');
        $this->serviceModel = $this->loadModel('service');
        $this->citizenModel = $this->loadModel('citizen');
        $this->organisationModel = $this->loadModel('organisation');
    }

    /**
     * Display create form and save customer record in database.
     * @throws Exception
     */
    public function create()
    {
        //if form submits then create customer
       if($_POST)
        {
            $serviceId = $_POST['service'] ? $_POST['service'] : null;
            $customerTypeId = $_POST['customerType'] ? ($_POST['customerType']) : null;
            if(!$serviceId || !$customerTypeId) {
                throw new Exception("Invalid service ot customer type. Can't create record!");
            }

            $customerType = $this->customerModel->getType($customerTypeId);
            $fieldsArray = [];
            //insert record for those customer types which has database table to store more information
            //for example citizen and organisation
            switch($customerType) {
                case CustomerModel::CUSTOMER_CITIZEN :
                    $title = $_POST['title'] ? $_POST['title'] : null;
                    $firstname = $_POST['firstname'] ? $_POST['firstname'] : null;
                    $lastname = $_POST['lastname'] ? $_POST['lastname'] : null;
                    if(!$firstname) {
                        throw new Exception("Invalid First name. Can't create record!");
                    }

                    $fieldsArray = [
                        'title' => $title,
                        'firstName' => $firstname,
                        'lastName' => $lastname
                    ];
                    break;
                case CustomerModel::CUSTOMER_ORGANISATION :
                    $name = $_POST['name'] ? $_POST['name'] : null;
                    if(!$name) {
                        throw new Exception("Invalid Organisation name. Can't create record!");
                    }

                    $fieldsArray = ['name' => $name];
                    break;
                default :
                    break;

            }

            $name = $this->getCustomerModelName($customerType);
            $this->customerModel->create([
                'custTypeId' => $customerTypeId,
                'custInfoId' => $name ? $this->$name->create($fieldsArray) : null,
                'serviceId' => $serviceId
            ]);
        }


        $template = $this->loadView('customer/create');
        $template->set('services', $this->serviceModel->listServices());
        $template->set('customerTypes', $this->customerModel->listTypes());
        $template->set('citizenTitles', $this->citizenModel->getTitles());
        $template->render();
    }

    /**
     * Showing currently queued people to the customers
     * @throws Exception
     */
    public function listQueue()
    {
        $customers = $this->customerModel->listCustomers();

        foreach ($customers as $key => $value) {
            $custTypeId = $value['custTypeId'];
            $custInfoId = $value['custInfoId'];
            $serviceId = $value['serviceId'];

            $value['customerType'] = $this->customerModel->getType($custTypeId);
            $name = $this->getCustomerModelName($value['customerType']);
            $value['customerName'] = $name ?
                $this->$name->getFullName($custInfoId) :
                CustomerModel::CUSTOMER_ANONYMOUS;
            $value['service'] = $this->serviceModel->getName($serviceId);
            $value['queueAt'] = date("H:i", strtotime($value['updated']));

            $customers[$key] = $value;

        }

        $template = $this->loadView('customer/queue');
        $template->set('customers', $customers);
        $template->render();
    }

    /**
     * this method returns model classname for respective customer type.
     * @param null $type
     * @return bool|string
     */
    private function getCustomerModelName($type = null)
    {
        $allowedModel = $this->customerModel->listTypes(true);
        if(!$type || !in_array($type, $allowedModel)) {
            return false;
        }

        return $type . "Model";
    }
}
?>


