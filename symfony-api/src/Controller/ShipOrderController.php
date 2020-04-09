<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Interfaces\ISavesRegistry;
use App\Entity\Person;
use App\Entity\ShipOrder;
use App\Entity\Destination;
use App\Entity\Item;



class ShipOrderController implements ISavesRegistry
{

    private function trataItens($itens)
    {
        $itens = (array) $itens[0];
        $itensFiltrados = [];
        if (!is_array($itens['item'])) {
            $itensFiltrados[] = $itens['item'];
        } else {
            $itensFiltrados = $itens['item'];
        }
        $itensTratados = [];
        foreach ($itensFiltrados as $i) {
            $itensTratados[] = (array) $i;
        }
        return $itensTratados;
    }

    public function saveRegistry($entityManager, $xml)
    {
        $mensagens = [];

        $xml = (array) $xml;

        foreach ($xml['shiporder'] as $ordem) {
            $ordem = (array) $ordem;
            $shipOrder = new ShipOrder();
            $shipOrder->setId((int) $ordem['orderid']);
            $person = $entityManager->getRepository(Person::class)->find((int) $ordem['orderperson']);
            $shipOrder->setOrderperson($person);
           
            try {
                $entityManager->persist($shipOrder);
                $entityManager->flush();
            } catch (\Exception $e) {
                $mensagens[] = $e->getMessage();
            }

            $destino = (array) $ordem['shipto'];
            $destination = new Destination();
            $destination->setName($destino['name']);
            $destination->setAddress($destino['address']);
            $destination->setCity($destino['city']);
            $destination->setCountry($destino['country']);
            $destination->setShiporder($shipOrder);

            try {
                $entityManager->persist($destination);
                $entityManager->flush();
            } catch (\Exception $e) {
                $mensagens[] = $e->getMessage();
            }

            $shipOrder->setDestination($destination);
           
            try {
                $entityManager->persist($shipOrder);
                $entityManager->flush();
            } catch (\Exception $e) {
                $mensagens[] = $e->getMessage();
            }

            $itens = $this->trataItens($ordem['items']);

            foreach ($itens as $i) {
                $i = (array) $i;
                $item = new Item();
                $item->setTitle($i['title']);
                $item->setNote($i['note']);
                $item->setQuantity((int) $i['quantity']);
                $item->setPrice((float) $i['price']);
                $item->setShiporder($shipOrder);
               
                try {
                    $entityManager->persist($item);
                } catch (\Exception $e) {
                    $mensagens[] = $e->getMessage();
                }
            }

            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                $mensagens[] = $e->getMessage();
            }
        }

        $resposta = [
            'sucesso' => true,
            'mensagens' => ""
        ];

        if (count($mensagens)) {
            $mensagensFiltradas = [];
            foreach($mensagens as $m){
                if($m != "The EntityManager is closed."){
                    $mensagensFiltradas[] = $m;
                }
            }
            
            $resposta = [
                'sucesso' => false,
                'mensagens' => $mensagensFiltradas
            ];
        }

        return $resposta;
    }
}
