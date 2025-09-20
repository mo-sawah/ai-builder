<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('wp_ajax_generate_concept', 'ai_builder_handle_ajax_request');
add_action('wp_ajax_nopriv_generate_concept', 'ai_builder_handle_ajax_request');

function ai_builder_handle_ajax_request() {
    // Verify nonce for security
    if (!check_ajax_referer('ai_builder_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => 'Security check failed.'], 403);
        return;
    }

    // Get form data
    $form_data_json = stripslashes($_POST['formData']);
    $input = json_decode($form_data_json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        wp_send_json_error(['message' => 'Invalid form data received.'], 400);
        return;
    }
    
    // Get settings
    $settings = get_option('ai_builder_settings');
    $provider = $settings['ai_provider'] ?? 'openai';
    
    $api_key = '';
    $api_url = '';
    $model = '';
    $headers = [];

    // Configure API request based on provider
    if ($provider === 'openai') {
        $api_key = $settings['openai_api_key'] ?? '';
        $api_url = 'https://api.openai.com/v1/chat/completions';
        $model = 'gpt-4o-mini'; // A cost-effective and powerful model
        $headers = [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json'
        ];
    } elseif ($provider === 'openrouter') {
        $api_key = $settings['openrouter_api_key'] ?? '';
        $api_url = 'https://openrouter.ai/api/v1/chat/completions';
        // Using Claude 3.5 Sonnet as it's excellent for this kind of detailed generation
        $model = 'anthropic/claude-3.5-sonnet'; 
        $headers = [
            'Authorization'               => 'Bearer ' . $api_key,
            'Content-Type'                => 'application/json',
            'HTTP-Referer'                => esc_url(home_url()), // Required by OpenRouter
            'X-Title'                     => 'AI Builder Plugin' // Recommended by OpenRouter
        ];
    }

    if (empty($api_key)) {
        wp_send_json_error(['message' => 'API key is not configured in AI Builder settings.'], 400);
        return;
    }

    // --- The new, much more detailed prompt ---
    $prompt = ai_builder_get_detailed_prompt($input);

    $body = [
        'model'    => $model,
        'messages' => [
            ['role' => 'system', 'content' => 'You are a world-class web strategist and consultant. Your task is to generate a comprehensive, detailed, and actionable website concept plan. You MUST respond ONLY with a valid JSON object, following the exact structure provided.'],
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.6,
        'max_tokens'  => 4000,
    ];
    
    // **FIX:** Conditionally add response_format ONLY for OpenAI, as OpenRouter/Claude does not support it.
    if ($provider === 'openai') {
        $body['response_format'] = ['type' => 'json_object'];
    }
    
    $args = [
        'body'    => json_encode($body),
        'headers' => $headers,
        'timeout' => 120, // Increased timeout for detailed generation
    ];
    
    // Make the API call
    $response = wp_remote_post($api_url, $args);

    if (is_wp_error($response)) {
        wp_send_json_error(['message' => 'Failed to connect to AI service: ' . $response->get_error_message()], 500);
        return;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);

    if ($response_code !== 200) {
        $error_data = json_decode($response_body, true);
        $error_message = $error_data['error']['message'] ?? 'An unknown API error occurred.';
        wp_send_json_error(['message' => "API Error ({$response_code}): {$error_message}"], $response_code);
        return;
    }

    $result = json_decode($response_body, true);
    $ai_response_content = $result['choices'][0]['message']['content'] ?? null;

    if (empty($ai_response_content)) {
        wp_send_json_error(['message' => 'AI returned an empty response.'], 500);
        return;
    }
    
    // In case the model doesn't respect the JSON mode, we try to find the JSON blob.
    if (strpos($ai_response_content, '{') !== 0) {
        $json_start = strpos($ai_response_content, '{');
        $json_end = strrpos($ai_response_content, '}');
        if ($json_start !== false && $json_end !== false) {
            $ai_response_content = substr($ai_response_content, $json_start, ($json_end - $json_start) + 1);
        }
    }

    $concept_data = json_decode($ai_response_content, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        wp_send_json_success($concept_data);
    } else {
        error_log('AI Builder JSON Parse Error: ' . json_last_error_msg());
        error_log('AI Builder Raw Response: ' . $ai_response_content);
        wp_send_json_error(['message' => 'AI returned an invalid response format. Please try again.'], 500);
    }
}


function ai_builder_get_detailed_prompt($input) {
    // Sanitize input data
    $business_type = sanitize_text_field($input['businessType'] ?? 'N/A');
    $industry = sanitize_text_field($input['industry'] ?? 'N/A');
    $target_audience = sanitize_text_field($input['targetAudience'] ?? 'N/A');
    $business_goal = sanitize_text_field($input['businessGoal'] ?? 'N/A');
    $description = sanitize_textarea_field($input['businessDescription'] ?? 'N/A');
    $website_type = sanitize_text_field($input['websiteType'] ?? 'Business Website');
    $design_style = sanitize_text_field($input['designStyle'] ?? 'Modern & Clean');
    $features_list = isset($input['features']) && is_array($input['features']) ? implode(', ', array_map('sanitize_text_field', $input['features'])) : 'None specified';

    return "
    Generate a comprehensive website concept based on the following client details.

    **Client Details:**
    - Business Name/Type: {$business_type}
    - Industry: {$industry}
    - Target Audience: {$target_audience}
    - Primary Business Goal: {$business_goal}
    - Business Description: {$description}
    - Desired Website Type: {$website_type}
    - Preferred Design Style: {$design_style}
    - Selected Features: {$features_list}

    **Your Task:**
    Create a detailed plan and respond ONLY with a single, valid JSON object with the following structure. Do NOT include any text, markdown, or explanations outside of the JSON object.

    **JSON Structure to Follow:**
    {
      \"projectOverview\": {
        \"title\": \"{$business_type}\",
        \"tagline\": \"[Create a compelling, industry-specific tagline]\",
        \"summary\": \"[Write a 2-3 sentence summary of the website's purpose and strategy based on the client's goal.]\",
        \"targetAudiencePersona\": \"[Describe the primary user persona in 1-2 sentences. E.g., 'Tech-savvy small business owners looking for scalable marketing solutions.']\",
        \"uniqueSellingProposition\": \"[Identify and state a clear USP for the website in one sentence.]\"
      },
      \"visualIdentity\": {
        \"colorPalette\": [
          {\"name\": \"Primary\", \"hex\": \"[HEX code]\", \"description\": \"[Usage context, e.g., Buttons, links]\"},
          {\"name\": \"Secondary\", \"hex\": \"[HEX code]\", \"description\": \"[Usage context, e.g., Accents, highlights]\"},
          {\"name\": \"Neutral (Dark)\", \"hex\": \"[HEX code]\", \"description\": \"[Usage context, e.g., Backgrounds]\"},
          {\"name\": \"Neutral (Light)\", \"hex\": \"[HEX code]\", \"description\": \"[Usage context, e.g., Text color]\"},
          {\"name\": \"Accent\", \"hex\": \"[HEX code]\", \"description\": \"[Usage context, e.g., Calls to Action]\"}
        ],
        \"typography\": {
          \"heading\": {\"font\": \"[Suggest a Google Font, e.g., 'Poppins']\", \"description\": \"[Describe its style, e.g., 'Modern, geometric, and friendly']\"},
          \"body\": {\"font\": \"[Suggest a complementary Google Font, e.g., 'Inter']\", \"description\": \"[Describe its style, e.g., 'Clean, highly legible, and versatile']\"}
        }
      },
      \"sitemap\": {
        \"pages\": [
          \"Home\",
          \"About Us\",
          \"Services/Products\",
          \"Case Studies/Portfolio\",
          \"Blog/News\",
          \"Contact Us\",
          \"Privacy Policy\"
        ]
      },
      \"wireframes\": {
        \"home_page\": [
          {\"section\": \"Header\", \"description\": \"Logo on the left, clear navigation (Home, About, Services, Contact), and a prominent 'Get a Quote' CTA button.\"},
          {\"section\": \"Hero Section\", \"description\": \"Compelling headline addressing the target audience's main pain point, a subheading with the USP, and a primary CTA button leading to the main goal (e.g., 'Schedule a Consultation').\"},
          {\"section\": \"Services Overview\", \"description\": \"A 3-column grid with icons, showcasing the core services. Each item should have a short, benefit-oriented description and a 'Learn More' link.\"},
          {\"section\": \"Social Proof/Testimonials\", \"description\": \"A carousel or grid displaying client testimonials with names and company, building trust and credibility.\"},
          {\"section\": \"About Us Snippet\", \"description\": \"A brief, mission-driven paragraph about the company, paired with a professional image. Includes a button to the full 'About Us' page.\"},
          {\"section\": \"Call to Action (CTA)\", \"description\": \"A full-width section with a strong benefit statement and a final, clear call to action, such as a newsletter signup or contact form.\"},
          {\"section\": \"Footer\", \"description\": \"Standard footer with contact info, social media links, navigation links, and privacy policy.\"}
        ],
        \"about_page\": [
          {\"section\": \"Header\", \"description\": \"Consistent with the homepage.\"},
          {\"section\": \"Introduction\", \"description\": \"Page title 'About Us' with a subheading explaining the company's mission and vision.\"},
          {\"section\": \"Our Story\", \"description\": \"A timeline or narrative section detailing the company's history and values.\"},
          {\"section\": \"Meet the Team\", \"description\": \"A grid of team members with photos, names, and titles.\"},
          {\"section\": \"Footer\", \"description\": \"Consistent with the homepage.\"}
        ],
         \"services_page\": [
          {\"section\": \"Header\", \"description\": \"Consistent with the homepage.\"},
          {\"section\": \"Service Details\", \"description\": \"A detailed breakdown of each service offered, with each service having its own sub-section including description, key benefits, and pricing info if applicable.\"},
          {\"section\": \"Process/How It Works\", \"description\": \"A visual step-by-step guide explaining the client engagement process.\"},
          {\"section\": \"FAQ\", \"description\": \"An accordion-style FAQ section addressing common questions about the services.\"},
          {\"section\": \"Footer\", \"description\": \"Consistent with the homepage.\"}
        ]
      },
      \"estimates\": {
        \"cost\": \"[Provide a realistic cost range, e.g., '$5,000 - $8,000']\",
        \"timeline\": \"[Provide a realistic timeline, e.g., '6-8 Weeks']\"
      }
    }
    ";
}

