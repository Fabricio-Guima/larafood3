<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Illuminate\Http\Request;

class OrderService
{
    protected $orderRepository, $tenantRepository, $tableRepository, $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository, 
        TenantRepositoryInterface $tenantRepository,
        TableRepositoryInterface $tableRepository
        ) {
        $this->orderRepository = $orderRepository;
        $this->tenantRepository = $tenantRepository;
        $this->tableRepository = $tableRepository;
       
    }

    public function createNewOrder(array $order) {
        $identify = $this->getIdentifyOrder();
        $total = $this->getTotalOrder([]);
        $status =  'open';
        $tenantId = $this->getTenantIdByOrder($order['token_company']);        
        $clientId = $this->getClientIdByOrder();
        $tableId = $this->getTableIdByOrder($order['table'] ?? '');

        $order = $this->orderRepository->createNewOrder(
            $identify,
            $total,
            $status,
            $tenantId,            
            $clientId,
            $tableId
        );

    }

    private function getIdentifyOrder(int $qtyCaraceters = 8){
        $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;

        // $specialCharacters = str_shuffle('!@#$%*-');

        // $characters = $smallLetters.$numbers.$specialCharacters;
        $characters = $smallLetters.$numbers;

        $identify = substr(str_shuffle($characters), 0, $qtyCaraceters);

        if ($this->orderRepository->getOrderByIdentify($identify)) {
            $this->getIdentifyOrder($qtyCaraceters + 1);
        }

        return $identify;
    }

    private function getTotalOrder(array $products): float {
        return (float) 90;
    }

    private function getTenantIdByOrder(string $uuid) {
        $tenant =  $this->tenantRepository->getTenantByUuid($uuid);
        return $tenant;
    }

    private function getTableIdByOrder(string $uuid = '') {
       if($uuid) {
        $table = $this->tableRepository->getTableByUuid($uuid);
        return $table->id;
       }

       return '';
    }

    private function getClientIdByOrder() {

        $client = auth()->check() ? auth()->user()->id : '';

        return $client;

    }
   
   

    

}