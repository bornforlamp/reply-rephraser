<?php
/*
Plugin Name: Reply Rephraser
Description: A simple plugin to send content to ChatGPT and return rephrased text in simple English with corrected grammar and a human tone (with Markdown support).
Version: 1.1
Author: Harshad Mane
*/

// Admin menu
add_action('admin_menu', function() {
    add_menu_page(
        'Reply Rephraser',
        'Reply Rephraser',
        'manage_options',
        'reply-rephraser',
        'reply_rephraser_page'
    );
});

// Plugin page
function reply_rephraser_page() {
    if (!current_user_can('manage_options')) return;

    if (isset($_POST['chatgpt_text'])) {
        $original_text = sanitize_textarea_field($_POST['chatgpt_text']);
        $rephrased = reply_get_rephrased_text($original_text);
    }
    ?>
    <div class="wrap">
        <h2>Reply Rephraser</h2>
        <form method="post">
            <textarea name="chatgpt_text" rows="6" style="width:100%;"><?php echo isset($original_text) ? esc_textarea($original_text) : ''; ?></textarea>
            <p><input type="submit" class="button button-primary" value="Rephrase"></p>
        </form>

        <?php if (!empty($rephrased)) : ?>
            <h3>✨ Rephrased Reply</h3>
            <div style="
                background: #f9f9f9;
                border: 1px solid #ddd;
                padding: 15px;
                border-radius: 8px;
                line-height: 1.6;
                font-size: 15px;
                color: #333;
                ">
                <?php
                    require_once plugin_dir_path(__FILE__) . 'Parsedown.php';
                    $Parsedown = new Parsedown();
                    echo $Parsedown->text($rephrased); // Render Markdown
                ?>
            </div>
            <p>
                <button onclick="navigator.clipboard.writeText(`<?php echo esc_js($rephrased); ?>`)" 
                        class="button button-secondary">
                    📋 Copy to Clipboard
                </button>
            </p>
        <?php endif; ?>
    </div>
    <?php
}

// Function to call ChatGPT API
function reply_get_rephrased_text($text) {
    $api_key = 'Enter your API key here'; // API key
    $url = 'https://api.openai.com/v1/chat/completions';

    $prompt = "Rephrase the following text into simple English, correct grammar, and keep it in a natural human tone. 
Always begin the message with a friendly greeting such as 'Hi', 'Hello', or 'Thank you for contacting Support!' 
and include an apology like 'Sorry to hear about the issue you are facing!' if missing. 
Always end the message with 'Best regards, <Your Name>'. 
Use Markdown formatting for readability when useful:\n\n" . $text;

    $body = json_encode([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.7
    ]);

    $args = [
        'body' => $body,
        'headers' => [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $api_key
        ],
        'timeout' => 60
    ];

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        return 'Error: ' . $response->get_error_message();
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
    return $data['choices'][0]['message']['content'] ?? 'No response received.';
}
