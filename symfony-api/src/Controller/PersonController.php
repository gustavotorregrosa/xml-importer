<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Interfaces\ISavesRegistry;
use App\Entity\Person;
use App\Entity\Phone;



class PersonController implements ISavesRegistry
{
    public function saveRegistry($entityManager, $xml)
    {
        $mensagens = [];

        foreach ($xml['person'] as $pessoa) {
            $pessoa = (array) $pessoa;
            $person = new Person();
            $person->setId((int) $pessoa['personid']);
            $person->setName($pessoa['personname']);

            try {
                $entityManager->persist($person);
            } catch (\Exception $e) {
                $mensagens[] = $e->getMessage();               
            }

            $telefones = (array) $pessoa['phones'];
            if (array_key_exists("phone", $telefones)) {
                $telefones = $telefones['phone'];
                if (is_string($telefones)) {
                    $telefones = [$telefones];
                }
                foreach ($telefones as $telefone) {
                    $phone = new Phone();
                    $phone->setPhonenumber($telefone);
                    $phone->setPerson($person);
                   
                    try {
                        $entityManager->persist($phone);
                    } catch (\Exception $e) {
                        $mensagens[] = $e->getMessage();               
                    }
                }
            }

            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                $mensagens[] = $e->getMessage();                
            }
        }

        $mensagensFiltradas = [];
            foreach($mensagens as $m){
                if($m != "The EntityManager is closed."){
                    $mensagensFiltradas[] = $m;
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
