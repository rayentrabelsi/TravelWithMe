<?php

namespace App\Controller;

use App\Entity\MoyTransport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;

class PdfGeneratorController extends AbstractController
{
    /**
     * @Route("/pdf/generator", name="pdf_generator")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données depuis la base de données
        $moyTransports = $entityManager->getRepository(MoyTransport::class)->findAll();

        // Convertir les images en base64
        foreach ($moyTransports as $moyTransport) {
            $path = 'public/assets/images/explore/' . $moyTransport->getTransportPicture();
            $moyTransport->setTransportPicture($this->imageToBase64($path));
        }

        $imageSrc = $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/Logo_ESPRIT_Ariana.jpg');

        // Vérifier s'il y a des enregistrements
        if (empty($moyTransports)) {
            $data = [
                'title' => 'TRANSPORT',
                'content' => 'Aucun enregistrement trouvé',
            ];
        } else {
            $data = [
                'title' => 'TRANSPORT',
                'moyTransports' => $moyTransports,
                'imageSrc' => $imageSrc,
            ];
        }

        $html = $this->renderView('pdf_generator/index.html.twig', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        $output = $dompdf->output();

        return new Response(
            $output,
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function imageToBase64($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        if ($data === false) {
            throw new \Exception('Impossible de lire le fichier image : ' . $path);
        }

        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
