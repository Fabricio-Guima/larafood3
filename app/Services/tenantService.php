<?php

namespace App\Services;

use App\Models\Plan;


class TenantService {

	private $plan, $data = [];

	public function __construct() {

	}

	public function make(Plan $plan, array $data) {
		
		$this->plan = $plan;
		$this->data = $data;

		$tenant = $this->storeTenant();
		 
		$user = $this->storeUser($tenant);

		return $user;

        
	}

	public function storeTenant() {

		$data = $this->data;

		return $this->plan->tenants()->create([
			//crio o uuid e a url única no observer
			'cnpj' => $data['cnpj'],           
            'name' => $data['empresa'],           
            'email' => $data['email'],
            'subscription' => now(),
            'expires_at' => now()->addDay(7),
		]);
		

	}

	public function storeUser($tenant) {

		$data = $this->data;

		 $user = $tenant->users()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
         ]);

		 return $user;

	}

}