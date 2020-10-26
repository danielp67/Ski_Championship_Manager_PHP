<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

final class ParticipantController extends AbstractController
{
    
    public function participantPage(): void
    {   
        echo $this->twig->render('participantView.html.twig');
    }

    public function participantExport(): Response
    {
        $list = array(
            //these are the columns
            array('Firstname', 'Lastname',),
            //these are the rows
            array('Andrei', 'Boar'),
            array('John', 'Doe')
        );
        $filename = 'users.csv';
        $fp = fopen('php://output', 'w','w');
    
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
    
        fclose($fp);
        $response = new Response();
        
        $response->headers->set('Content-Type', 'text/csv');
        //it's gonna output in a testing.csv file
        $response->headers->set('Content-Disposition', 'attachment; filename='. $filename);
       
        $response->sendHeaders();
       
       // var_dump($response);
        return $response;
    }

    public function participantForm(): void
    {
        echo $this->twig->render('participantForm.html.twig');
    }

    public function participantList(): void
    {
        $participantRepository = new ParticipantRepository($this->pdo);
        $participantList = $participantRepository->findAll();
        echo $this->twig->render('participantList.html.twig', ['participants' => $participantList]);
    }

    public function participantCheck(): void
    {
        $request = Request::createFromGlobals();
        var_dump($request->request);
        var_dump($request->files);

        
      //  echo $this->twig->render('participantAdd.html.twig');
    }

    public function participantImg($id)
    {
        var_dump($id);
        $theImage = 'C:/wamp64/www/tp15_championnat_ski/data/img/'.$id;
        var_dump($theImage);
        $response = new Response();
        $response->headers->set('content-type','image/jpg');
        $response->setContent(file_get_contents($theImage));

        return $response;
    }
}
