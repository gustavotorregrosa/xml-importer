<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class XMLFilesController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

   /**
     * @Route("/fileupload")
     */
    public function recebeArquivo(Request $request){
        $arquivo = $request->files->get('arquivos');
        $arquivos = [$arquivo];
        $nomesArquivos = $this->listaArquivos($arquivos);
        $arrayXML = $this->geraXML($nomesArquivos);
        $arrayXML = $this->ordenaXML($arrayXML);
        $statusGeral = [];

        foreach($arrayXML as $xml){
            $nomeControllerRegistro = "";
            if(array_key_exists("person", $xml)){
               $nomeControllerRegistro = 'PersonController';
            }

            if(array_key_exists("shiporder", $xml)){
                $nomeControllerRegistro = 'ShipOrderController';
            }

            $controladorRegistro = $this->getRegistryController($nomeControllerRegistro);
            $status = $controladorRegistro->saveRegistry($this->entityManager, $xml);
            $statusGeral[] = $status;
            
        }    
        
       $respostaArray = $this->gerarResposta($statusGeral); 
       $codigo = $respostaArray['sucesso'] ? 200 : 500;

       $resposta =  new Response(json_encode($respostaArray), $codigo);
       $resposta->headers->set('Content-Type', 'application/json');
       $resposta->headers->set('Access-Control-Allow-Origin', '*');
       return $resposta;



    }

    private function gerarResposta($statusGeral){
        $sucesso = true;
        $mensagem = ["Import realiado com sucesso"];
        $mensagensErro = [];
        $codigo = 200;

        foreach($statusGeral as $status){
            if(!$status['sucesso']){
                $sucesso = false;
                $codigo = 500;
                foreach($status['mensagens'] as $m){
                    $mensagensErro[] = $m;
                    $mensagem = $mensagensErro;
                }
            }
        }

        return [
            'sucesso' => $sucesso,
            'mensagem' => $mensagem,
            'codigo' => $codigo 
        ];
    }

    private function ordenaXML($arrayXML){
        if(count($arrayXML) == 1){
            return $arrayXML;
        }

        $arrayOrdenado = [];
        foreach($arrayXML as $xml){
            if(array_key_exists("person", $xml)){
                $arrayOrdenado[] = $xml;
            }
        }
        foreach($arrayXML as $xml){
            if(array_key_exists("shiporder", $xml)){
                $arrayOrdenado[] = $xml;
            }
        }

        return $arrayOrdenado;
    }

    private function listaArquivos($arquivos){
        $nomesArquivos = [];
        foreach($arquivos as $a){
            $nomesArquivos[] = $a->getRealPath();
        }
        return $nomesArquivos;

    }

    private function getRegistryController ($name) {
        $nomeControllerRegistro = "\App\Controller\\".$name;
        $class = new \ReflectionClass($nomeControllerRegistro);
        return $class->newInstanceArgs();
        
    }

    private function geraXML($arquivos){
        $arrayXML = [];
        foreach($arquivos as $arquivo){
            $arrayXML[] = (array) simplexml_load_file($arquivo);
        }
        return $arrayXML;
    }
    

    

}

