<?php
namespace Slack_Interface;
use Requests;
/**
 * A basic Slack interface you can use as a starting point
 * for your own Slack projects.
 */
class Slack {

    private static $api_root = 'https://slack.com/api/';
    /**
     * @var Slack_Access    Slack authorization data
     */
    private $access;
    /**
     * @var array $slash_commands   An associative array of slash commands
     *                              attached to this Slack interface
     */
    private $slash_commands;

    /**
     * Sets up the Slack interface object.
     *
     * @param array $access_data An associative array containing OAuth
     *                           authentication information. If the user
     *                           is not yet authenticated, pass an empty array.
     */
    public function __construct( $access_data ) {
        if ( $access_data ) {
            $this->access = new Slack_Access( $access_data );
        }
        Requests::register_autoloader();
        $this->slash_commands = array();
    }
    /**
     * Registers a new slash command to be available through this
     * Slack interface.
     *
     * @param string    $command    The slash command
     * @param callback  $callback   The function to call to execute the command
     */
    public function register_slash_command( $command, $callback ) {
        $this->slash_commands[$command] = $callback;
    }
    /**
     * Runs a slash command passed in the $_POST data if the
     * command is valid and has been registered using register_slash_command.
     *
     * The response written by the function will be read by Slack.
     */
    public function do_slash_command() {
        // Collect request parameters
        $token      = isset( $_POST['token'] ) ? $_POST['token'] : '';
        $command    = isset( $_POST['command'] ) ? $_POST['command'] : '';
        $text       = isset( $_POST['text'] ) ? $_POST['text'] : '';
        $user_name  = isset( $_POST['user_name'] ) ? $_POST['user_name'] : '';
        // Use the command verification token to verify the request
        if ( ! empty( $token ) && $this->get_command_token() == $_POST['token'] ) {
            header( 'Content-Type: application/json' );

            if ( isset( $this->slash_commands[$command] ) ) {
                // This slash command exists, call the callback function to handle the command
                $response = call_user_func( $this->slash_commands[$command], $text, $user_name );
                echo json_encode( $response );
            } else {
                // Unknown slash command
                echo json_encode( array(
                    'text' => "Sorry, I don't know how to respond to the command."
                ) );
            }
        } else {
            echo json_encode( array(
                'text' => 'Oops... Something went wrong.'
            ) );
        }

        // Don't print anything after the response
        exit;
    }
    /**
     * Returns the command verification token.
     *
     * @return string   The command verification token or empty string if not configured
     */
    private function get_command_token() {
        // First, check if command token is defined in a constant
        if ( defined( 'SLACK_COMMAND_TOKEN' ) ) {
            return SLACK_COMMAND_TOKEN;
        }

        // If no constant found, look for environment variable
        if ( getenv( 'SLACK_COMMAND_TOKEN' ) ) {
            return getenv( 'SLACK_COMMAND_TOKEN' );
        }

        // Not configured, return empty string
        return '';
    }
    /**
     * Returns the Slack client ID.
     *
     * @return string   The client ID or empty string if not configured
     */
    public function get_client_id() {
        // First, check if client ID is defined in a constant
        if ( defined( 'SLACK_CLIENT_ID' ) ) {
            return SLACK_CLIENT_ID;
        }

        // If no constant found, look for environment variable
        if ( getenv( 'SLACK_CLIENT_ID' ) ) {
            return getenv( 'SLACK_CLIENT_ID' );
        }

        // Not configured, return empty string
        return '';
    }
    /**
     * Checks if the Slack interface was initialized with authorization data.
     *
     * @return bool True if authentication data is present. Otherwise false.
     */
    public function is_authenticated() {
        return isset( $this->access ) && $this->access->is_configured();
    }

    /**
     * Returns the Slack client secret.
     *
     * @return string   The client secret or empty string if not configured
     */
    private function get_client_secret() {
        // First, check if client secret is defined in a constant
        
        if ( defined( 'SLACK_CLIENT_SECRET' ) ) {
            return SLACK_CLIENT_SECRET;
        }

        // If no constant found, look for environment variable
        if ( getenv( 'SLACK_CLIENT_SECRET' ) ) {
            return getenv( 'SLACK_CLIENT_SECRET' );
        }

        // Not configured, return empty string
        return '';
    }
    /**
     * Completes the OAuth authentication flow by exchanging the received
     * authentication code to actual authentication data.
     *
     * @param string $code  Authentication code sent to the OAuth callback function
     *
     * @return bool|Slack_Access    An access object with the authentication data in place
     *                              if the authentication flow was completed successfully.
     *                              Otherwise false.
     *
     * @throws Slack_API_Exception
     */
    public function do_oauth( $code ) { 

        // Set up the request headers
        $headers = array( 'Accept' => 'application/json' );

        // Add the application id and secret to authenticate the request
        $options = array( 'auth' => array( $this->get_client_id(), $this->get_client_secret() ) );
//        return $this->get_client_id().'//'.$this->get_client_secret();exit;
        // Add the one-time token to request parameters
        $data = array( 'code' => $code );

        $response = Requests::post(self::$api_root . 'oauth.access', $headers, $data, $options);
//        print('<pre>');
//        return($response);exit;
        // Handle the JSON response
        $json_response = json_decode( $response->body );

        if ( ! $json_response->ok ) {
            // There was an error in the request
            throw new Slack_API_Exception( $json_response->error );
        }

        // The action was completed successfully, store and return access data
        $this->access = new Slack_Access(
            array(
                'access_token' => $json_response->access_token,
                'scope' => explode( ',', $json_response->scope ),
                'team_name' => $json_response->team_name,
                'team_id' => $json_response->team_id,
                'incoming_webhook' => $json_response->incoming_webhook
            )
        );

        return $this->access;
    }
    /**
     * Sends a notification to the Slack channel defined in the
     * authorization (Add to Slack) flow.
     *
     * @param string $text          The message to post to Slack
     * @param array $attachments    Optional list of attachments to send
     *                              with the notification
     *
     * @throws Slack_API_Exception
     */
    public function send_notification( $text, $attachments = array() ) {
        if ( ! $this->is_authenticated() ) {
            throw new Slack_API_Exception( 'Access token not specified' );
        }

        // Post to webhook stored in access object
        $headers = array( 'Accept' => 'application/json' );

        $url = $this->access->get_incoming_webhook();
        $data = json_encode(
            array(
                'text' => $text,
                'attachments' => $attachments,
                'channel' => $this->access->get_incoming_webhook_channel(),
            )
        );

        $response = Requests::post( $url, $headers, $data );

        if ( $response->body != 'ok' ) {
            throw new Slack_API_Exception( 'There was an error when posting to Slack' );
        }
    }

}