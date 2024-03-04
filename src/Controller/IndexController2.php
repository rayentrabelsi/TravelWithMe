<?php
    
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use App\Repository\VoyageRepository;
    use Symfony\Component\HttpClient\HttpClient;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpKernel\Log\LoggerInterface;
    use App\Form\ChatType;
    use App\Service\AI21Service;
    use App\Entity\ChatResponse;
    use App\Service\ChatGPTClient;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Contracts\HttpClient\HttpClientInterface;
    use Dompdf\Dompdf;
    use Dompdf\Options;
    use App\Service\OpenWeatherMapService; 



    class IndexController2 extends AbstractController
    {        
    /**
 * @Route("/main", name="main")
 */
public function index(
    Request $request,
    VoyageRepository $voyageRepository,
    AI21Service $ai21Service,
    SessionInterface $session,
    HttpClientInterface $httpClient,
    OpenWeatherMapService $weatherService
): Response {
    // Get all voyages
    $voyages = $voyageRepository->findAll();

    // Get user's location from session or other source
    $latitude = $request->getSession()->get('user_latitude');
    $longitude = $request->getSession()->get('user_longitude');

    // Fetch weather data based on GPS coordinates
    $weatherData = $weatherService->getCurrentWeather('Bizerte');

    // Sort voyages by proximity

    // Get chat responses from session
    $chatResponses = $session->get('chat_responses', []);

    return $this->render('index.html.twig', [
        'controller_name' => 'IndexController2',
        'chat_responses' => $chatResponses,
        'voyages' => $voyages,  
        'weatherData' => $weatherData,
    ]);
}




/**
 * @Route("/chat", name="chat", methods={"POST"})
 */
public function chat(Request $request, AI21Service $ai21Service, SessionInterface $session, VoyageRepository $voyageRepository): Response
{
    $input = $request->request->get('input');

    // Check if input is provided
    if ($input === null) {
        // Handle the case when input is not provided
        // For example, return an error response
        return new Response('Input is required', Response::HTTP_BAD_REQUEST);
    }

    // Call the AI service with the provided input
    $response = $ai21Service->generateResponse($input);

    // Extract the generated text from the response
    $generatedText = $response['completions'][0]['data']['text'];

    // Store the generated text in the session, replacing any existing text
    $session->set('generated_text', $generatedText);

    // Get the voyages for rendering the main page
    $voyages = $voyageRepository->findAllWithDetails();
    

    // Render the main page with voyages and chat responses
    return $this->render('chat.html.twig', [
        'controller_name' => 'IndexController2',
        'voyages' => $voyages,
        'chat_responses' => [$generatedText], // Only the latest generated text is passed
    ]);
}
/**
 * @Route("/generate-pdf/{voyageId}", name="generate_pdf")
 */
public function generatePdfAction(int $voyageId, VoyageRepository $voyageRepository)
{
    // Fetch the voyage by ID
    $voyage = $voyageRepository->findVoyageById($voyageId);

    if (!$voyage) {
        throw $this->createNotFoundException('Voyage not found');
    }

    // Create an instance of Dompdf
    $dompdf = new Dompdf();

    // Load HTML content for the PDF
    $html = $this->renderView('pdf_template.html.twig', [
        'voyage' => $voyage,
    ]);

    // Load HTML to Dompdf      
    $dompdf->loadHtml($html);

    // (Optional) Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Output the generated PDF to the browser
    return new Response($dompdf->output(), Response::HTTP_OK, [
        'Content-Type' => 'application/pdf',
    ]);
}

/**
     * @Route("/weather", name="weather")
     */
    public function weather(OpenWeatherMapService $weatherService): Response
    {
        $weatherData = $weatherService->getCurrentWeather('London');
        // Do something with the weather data
        return $this->render('weather.html.twig', [
            'weatherData' => $weatherData,
        ]);
    }
    }

