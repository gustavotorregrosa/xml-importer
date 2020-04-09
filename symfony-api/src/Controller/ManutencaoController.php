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


class ManutencaoController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
    * @Route("/limpabanco")
    */
    public function limpaBanco(){

        $itens = $this->entityManager->getRepository(Item::class)->findAll();
        foreach($itens as $item){
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();

        $destinations = $this->entityManager->getRepository(Destination::class)->findAll();
        foreach($destinations as $destination){
            $this->entityManager->remove($destination);
        }
        $this->entityManager->flush();

        $shipOrders = $this->entityManager->getRepository(ShipOrder::class)->findAll();
        foreach($shipOrders as $shipOrder){
            $this->entityManager->remove($shipOrder);
        }
        $this->entityManager->flush();

        $phones = $this->entityManager->getRepository(Phone::class)->findAll();
        foreach($phones as $phone){
            $this->entityManager->remove($phone);
        }
        $this->entityManager->flush();

        $persons = $this->entityManager->getRepository(Person::class)->findAll();
        foreach($persons as $person){
            $this->entityManager->remove($person);
        }
        $this->entityManager->flush();

        
        $resposta = new Response('Banco limpo com sucesso');
        $resposta->headers->set('Content-Type', 'application/json');
        $resposta->headers->set('Access-Control-Allow-Origin', '*');
        return $resposta;
  
     }

}