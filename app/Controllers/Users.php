<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\Users as UsersModel;


class Users extends BaseController
{
    use ResponseTrait;

	public function index()
	{
        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $query   = $builder->get();
       
        return json_encode($query->getResult());
		
    }
    
    public function show($id)
    {
        $users = new UsersModel;
        
        $user = $users->find($id);

        if (! $user) {

            return $this->failNotFound('l\'utilisateur n\'est pas en bdd');
        }

        return $this->respond($user);

    }


    public function create()
    {   
        
        $data = json_decode($this->request->getBody());


        if(empty($data)) {
            throw new \Exception('Can not decode post data');
        }


        $users = new UsersModel();

        
        $id = $users->insert($data);

        if ($users->errors()){
            return $this->fail($users->errors());
        }

        if ($id === false) {
            return $this->failServerError();
        }

        $user = $users->find($id);
        // ajoute un element dans la response json sans etre en bdd 
        $user['url'] = site_url('/users/'. $id);
        // ajoute un elemant dans le header 
        $this->response->setHeader('location', $user['url']);


        return $this->respondCreated($user);
    }

    public function update($id)
    {

        $data = json_decode($this->request->getBody());
        
        $users = new UsersModel();

        $users->update($id, $data);

        if ($users->errors()) {

            return $this->fail($users->errors());
        }

        if ($users === false) {
            return $this->failServerError();
        }

        $user = $users->find($id);

        return $this->respondUpdated($user);
    }

    public function delete($id)
    {

        $users = new UsersModel();

        $user = $users->select('id')->find($id);

        if (!$user)
        {
            return $this->fail('l\'utilisateur n\'est pas en bdd', 404);
        }

        if ($users->delete($id)){

            return $this->respondDeleted();

        }
        else {

            return $this->failServerError();

        }

        $deleted = $users->delete($id);

        return $this->respondDeleted($deleted);
    }


}
