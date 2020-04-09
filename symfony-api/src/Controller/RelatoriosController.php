<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Item;
use App\Entity\Destination;
use App\Entity\ShipOrder;
use App\Entity\Phone;
use App\Entity\Person;


class RelatoriosController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/pessoas")
     */
    public function exibePessoas()
    {
        $arrayPessoas = [];
        $pessoas = $this->entityManager->getRepository(Person::class)->findAll();
        foreach ($pessoas as $p) {
            $pessoaReg = [
                'id' => $p->getId(),
                'name' => $p->getName(),
                'phoneNumbers' => []
            ];

            $telefones = $p->getPhones();
            foreach ($telefones as $t) {
                $pessoaReg['phoneNumbers'][] = $t->getPhonenumber();
            }

            $arrayPessoas[] = $pessoaReg;
        }

        $resposta =  new Response(json_encode($arrayPessoas), 200);
        $resposta->headers->set('Content-Type', 'application/json');
        $resposta->headers->set('Access-Control-Allow-Origin', '*');
        return $resposta;
    }


    /**
     * @Route("/ordens")
     */
    public function exibeOrdens()
    {
        $arrayOrdens = [];
        $ordens = $this->entityManager->getRepository(ShipOrder::class)->findAll();
        foreach ($ordens as $ordem) {
            $ordemReg = [];

            $ordemReg['id'] = $ordem->getId();
            $pessoa = $ordem->getOrderperson();
            $ordemReg['person'] = [
                'id' => $pessoa->getId(),
                'name' => $pessoa->getName()
            ];

            $destination = $ordem->getDestination();

            $ordemReg['destination'] = [
                'name' => $destination->getName(),
                'address' => $destination->getAddress(),
                'city' => $destination->getCity(),
                'country' => $destination->getCountry()
            ];

            $items = $ordem->getItems();
           
            foreach($items as $i){
                $itemReg = [
                    'title' => $i->getTitle(),
                    'note' => $i->getNote(),
                    'quantity' => $i->getQuantity(),
                    'price' => $i->getPrice()
                ];

                $ordemReg['itens'][] = $itemReg;
            }
            $arrayOrdens[] = $ordemReg;
        }

        $resposta =  new Response(json_encode($arrayOrdens), 200);
        $resposta->headers->set('Content-Type', 'application/json');
        $resposta->headers->set('Access-Control-Allow-Origin', '*');
        return $resposta;


    }
}
