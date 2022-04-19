<?php
/**
 * A lightweight example script for demonstrating how to
 * work with the Slack API.
 */

// Define Slack application identifiers
// Even better is to put these in environment variables so you don't risk exposing
// them to the outer world (e.g. by committing to version control)
define( 'SLACK_CLIENT_ID', '157241478784.157988788004' );
define( 'SLACK_CLIENT_SECRET', 'eced17ec5d8338aef1c8fc1b169ae34f' );
define( 'SLACK_COMMAND_TOKEN', 'kZwIAuTdmrQgvvARyE6IQlBc' );

// Include our Slack interface classes
require_once 'slack-interface/class-slack.php';
require_once 'slack-interface/class-slack-access.php';
require_once 'slack-interface/class-slack-api-exception.php';
require_once 'Requests/library/Requests.php';


use Slack_Interface\Slack;
use Slack_Interface\Slack_API_Exception;


//
// HELPER FUNCTIONS
//

/**
 * Initializes the Slack handler object, loading the authentication
 * information from a text file. If the text file is not present,
 * the Slack handler is initialized in a non-authenticated state.
 *
 * @return Slack    The Slack interface object
 */
function initialize_slack_interface() {
    // Read the access data from a text file
    if ( file_exists( 'access.txt' ) ) {
        $access_string = file_get_contents( 'access.txt' );
    } else {
        $access_string = '{}';
    }

    // Decode the access data into a parameter array
    $access_data = json_decode( $access_string, true );

    $slack = new Slack( $access_data );
// Register slash commands
    $slack->register_slash_command( '/joke', 'slack_command_joke' );
    return $slack;

}
/**
 * A simple slash command that returns a random joke to the Slack channel.
 *
 * @return array    A data array to return to Slack
 */
function slack_command_joke() {
    $file = fopen("jokes.txt","a");
    echo fwrite($file,json_encode($_REQUEST));
    fclose($file);
    return 'not authorised';
//   return $_REQUEST['text'] . ' created successfully1234' ;

//    $jokes = array(
//        "The box said 'Requires Windows Vista or better.' So I installed LINUX.",
//        "Bugs come in through open Windows.",
//        "Unix is user friendly. It’s just selective about who its friends are.",
//        "Computers are like air conditioners: they stop working when you open Windows.",
//        "I would love to change the world, but they won’t give me the source code.",
//        "Programming today is a
//        race between software engineers striving to build bigger and better idiot-proof
//        programs, and the Universe trying to produce bigger and better idiots. So far, the Universe is winning."
//    );
//
//    $joke_number = rand( 0, count( $jokes ) - 1 );
//
//    return array(
//        'response_type' => 'in_channel',
//        'text' => $jokes[$joke_number],
//    );
}

/**
 * Executes an application action (e.g. 'send_notification').
 *
 * @param Slack  $slack     The Slack interface object
 * @param string $action    The id of the action to execute
 *
 * @return string   A result message to show to the user
 */
function do_action( $slack, $action ) {
    $result_message = '';

    switch ( $action ) {

        // Handles the OAuth callback by exchanging the access code to
        // a valid token and saving it in a file
        case 'oauth':
            $code = $_GET['code'];

            // Exchange code to valid access token
            try {
                $access = $slack->do_oauth( $code );
                if ( $access ) {
                    file_put_contents( 'access.txt', $access->to_json() );
                    $result_message = 'The application was successfully added to your Slack channel';
                }
            } catch ( Slack_API_Exception $e ) {
                $result_message = $e->getMessage();
            }
            break;
        // Sends a notification to a Slack channel
        case 'send_notification':
            $message = isset( $_REQUEST['text'] ) ? $_REQUEST['text'] : 'Hello!';

            try {
                $attachments = array(
                    array(
                        'fallback' => 'Jarkko just posted a new bread recipe.',

                        'title' => 'Sprouted Wheat Bread',
                        'title_link' => 'https://bread-magazine.com/sprouted-wheat-flour/',

                        'text' => 'Jarkko just posted a new bread recipe. Check it out.',

                        'color' => '#7CD197',

                        'fields' => array(
                            array(
                                'title' => 'Preparation time',
                                'value' => ':hourglass: 24 hours',
                                'short' => true
                            ),
                            array(
                                'title' => 'Difficulty',
                                'value' => 'Medium',
                                'short' => true
                            ),
                        ),
                        'image_url' => 'https://s3.amazonaws.com/interested/wordpress/wp-content/uploads/2015/02/12093547/sprouted-bread.jpg'
                    )
                );

//                $slack->send_notification( $message, $attachments );
                $slack->send_notification( $message, $attachments );
                $result_message = 'Notification sent to Slack channel.';
            } catch ( Slack_API_Exception $e ) {
                $result_message = $e->getMessage();
            }
            break;
// Responds to a Slack slash command. Notice that commands are 
// registered at Slack initialization.
        case 'command':
            $slack->do_slash_command();
            break;
        default:
            break;

    }

    return $result_message;
}
//
// MAIN FUNCTIONALITY
//

// Setup the Slack interface
$slack = initialize_slack_interface();

// If an action was passed, execute it before rendering the page
$result_message = '';
if ( isset( $_REQUEST['action'] ) ) {
    $action = $_REQUEST['action'];
    $result_message = do_action( $slack, $action );
}

//
// PAGE LAYOUT
//

?>
<html>
<head>
    <title>Slack Integration Example</title>

    <style>
        body {
            font-family: Helvetica, sans-serif;
            padding: 20px;
        }

        .notification {
            padding: 20px;
            background-color: #fafad2;
        }

        input {
            padding: 10px;
            font-size: 1.2em;
            width: 100%;
        }
    </style>
</head>

<body>
<h1>Slack Integration Example</h1>

<?php if ( $result_message ) : ?>
    <p class="notice">
        <?php echo $result_message; ?>
    </p>
<?php endif; ?>

<?php if ( $slack->is_authenticated() ) : ?>
    <form action="" method="post">
        <input type="hidden" name="action" value="send_notification"/>
        <p>
            <input type="text" name="text" placeholder="Type your notification here and press enter to send." />
        </p>
    </form>
    <p>
        <a href="https://slack.com/oauth/authorize?scope=incoming-webhook,commands&client_id=<?php echo $slack->get_client_id(); ?>"><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x"></a>
    </p>
<?php endif; ?>
</body>
</html>