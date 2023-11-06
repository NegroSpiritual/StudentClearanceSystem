<?php
// Check if a POST request with 'userMessage' parameter is received
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userMessage'])) {
    // Get the user's message from the POST request
    $userMessage = strtolower($_POST['userMessage']); // Convert input to lowercase for case-insensitivity

    // Process the user's message using chatbot logic
    $chatbotResponse = processUserMessage($userMessage);

    // Create a response object
    $response = array('message' => $chatbotResponse);

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle invalid or unsupported requests
    http_response_code(400); // Bad Request
    echo "Invalid request.";
}

// Function to process the user's message (chatbot logic)
function processUserMessage($userMessage) {
    // Define an array of possible greetings (case-insensitive)
    $greetings = array('hello', 'hi', 'hey', 'greetings', 'good day', 'morning', 'afternoon', 'evening');

    // Define responses to school clearance questions
    $schoolClearanceResponses = array(
        'what is school clearance' => 'School clearance is the process of completing all necessary requirements and obligations, such as returning library books, paying outstanding fees, and resolving any academic or administrative issues before a student can graduate or leave the school.',
        'when is the school clearance deadline' => 'The school clearance deadline may vary depending on your school\'s policies. It\'s important to check with your school\'s clearance office or academic advisors for specific information about the deadline.',
        'default' => 'I\'m sorry, I don\'t have information on that specific topic. Please feel free to ask another question.'
        //'how do I complete school clearance' => 'To complete school clearance, you need to follow the instructions provided by your school\'s clearance office. This may involve returning library materials, settling outstanding fees, submitting required documents, and attending clearance sessions.'
    );

    // Check if the user's input (in lowercase) matches any school clearance questions (in lowercase)
    foreach ($schoolClearanceResponses as $question => $response) {
        if (strpos($userMessage, $question) !== false) {
            return $response;
        }
    }

    // Check if the user's input (in lowercase) matches any greetings (in lowercase)
    if (in_array($userMessage, $greetings)) {
        return "Hello! How can I assist you?";
    } else {
        // If not a greeting or school clearance question, provide a default response
        return "I'm sorry, I don't understand. Please ask a different question.";
    }
}
?>
