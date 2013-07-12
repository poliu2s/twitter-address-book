<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth.php');
require_once('config.php');



/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
    exit();
}
$sign_in_button = '<a class="btn btn-large btn-inverse" href="clearsessions.php">Sign out</a>';
$no_friends_msg = "<hr><p>Doesn't look like you have any friends at the moment. Try adding some =D </p>";
$sign_in = 0;


/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];
$screen_name = $access_token['screen_name'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);


// Check Twitter REST API v1.1 rate limit status
$rate_limit_request = (array) $connection->get('application/rate_limit_status');

// Retrieve rate limit request bottleneck on users/show
$rate_limit_resources = (array) $rate_limit_request['resources'];
$rate_limit_users = (array) $rate_limit_resources['users'];
$rate_limit_showid = (array)$rate_limit_users['/users/show/:id'];
$rate_limit_showid_remaining = $rate_limit_showid['remaining'];

// Set Twitter request throttling
// Leave buffer of 50 requests/15 min in case user wants to add or modify entries
$rate_throttle_lower_bound = 50; 

// Login creditials for local address book database
$host="fdb5.biz.nf";
$username="1452729_book";
$password="ep88son";
$db_name="1452729_book";

$db = new mysqli("$host", "$username", "$password", "$db_name") or die("Database could not connect");
$query = "SELECT *
        FROM addresses
        WHERE owner='$screen_name'";
$result = $db->query($query);


// Delete an entry from the address book
if(isset($_GET['delete'])) {
	// Protect against SQL injection
	$delete_target = mysql_real_escape_string($_GET['delete']);

	$sql_del_entry = "DELETE FROM addresses
					  WHERE (t_handle='$delete_target') AND (owner='$screen_name') ";
	$db->query($sql_del_entry);
	unset($_GET['delete']);
	header('Location: http://poliu.co.nf');
} else {
	$refresh_page = "";
}

// Add entry into the address book
if (isset($_GET['fname'])) {
	$follower_count_request = (array) $connection->get("users/show", array("screen_name" => "{$_GET['ft_handle']}"));
	$num_followers = $follower_count_request['followers_count'];

	// Protect against SQL injection
	$fname_tmp = mysql_real_escape_string($_GET['fname']);
	$fphone_tmp = mysql_real_escape_string($_GET['fphone']);
	$ft_handle_tmp = mysql_real_escape_string($_GET['ft_handle']);

	$entryAdd = "INSERT INTO addresses
				VALUES (
				'$fname_tmp',  '$fphone_tmp',  '$ft_handle_tmp', '$screen_name', '$num_followers'
				);";
	$db->query($entryAdd);
	unset($_GET['fname']);
	unset($_GET['fphone']);
	unset($_GET['ft_handle']);
	header('Location: http://poliu.co.nf');
}

// Update an entry in the address book
if (isset($_GET['ename'])) {
	$follower_count_request = (array) $connection->get("users/show", array("screen_name" => "{$_GET['et_handle']}"));
	$num_followers = $follower_count_request['followers_count'];

	// Protect against SQL injection
	$ename_tmp = mysql_real_escape_string($_GET['ename']);
	$ephone_tmp = mysql_real_escape_string($_GET['ephone']);
	$et_handle_tmp = mysql_real_escape_string($_GET['et_handle']);

	$edit_update_query = "UPDATE addresses
						  SET name='$ename_tmp', phone='$ephone_tmp', t_handle='$et_handle_tmp', followers='$num_followers'
						  WHERE (t_handle='$et_handle_tmp') AND (owner='$screen_name');
						   ";
	$db->query($edit_update_query);

	unset($_GET['ename']);
	unset($_GET['ephone']);
	unset($_GET['et_handle']);
	header('Location: http://poliu.co.nf');

}

// Show all entries in the address book
$num_results = $result->num_rows;
$num_followers = -1; // error value
$entries = array();
for($i = 0; $i < $num_results; $i++) {
	$row = $result->fetch_assoc();

	// Look to see if we already have the number of followers for this entry in the db
	// If not, then make a request and cache it in the db
	if (is_null($row['followers']) || $rate_limit_showid_remaining > $rate_throttle_lower_bound) {
		$follower_count_request = (array) $connection->get("users/show", array("screen_name" => "{$row['t_handle']}"));
		$num_followers = $follower_count_request['followers_count'];

		$sql_update_followers = "UPDATE addresses
								 SET followers='$num_followers'
								 WHERE t_handle='{$row['t_handle']}'";
		$db->query($sql_update_followers);

	} else {
		
		$num_followers = $row['followers'];
	}
	

	$entries[$i]= "
			<div class=\"row-fluid\">
				<div class=\"span6\">
					<h3>{$row['name']}</h3>
					<p>
						<b>Phone: </b>" . substr($row['phone'], 0, 3) .".". substr($row['phone'], 3, 3) . "." . substr($row['phone'], 6, 10) . "<br>
						<b>Handle: </b> {$row['t_handle']} <br>
						<b>Followers: </b> $num_followers <br>	
					</p>
				</div>
				<div class=\"span6\">
				<br><br>
					<table border=0 cellpadding=0>
					<tr>
					<td valign=\"bottom\"><form action=\"index.php\" method=\"get\">
						<input type=\"hidden\" name=\"delete\" value=\"{$row['t_handle']}\">
						<input class=\"btn-medium btn-danger\" type=\"submit\" value=\"Delete\">
					</form>
					</td>
					<td valign=\"bottom\">
					<form action=\"index.php\" method=\"get\">
						<input type=\"hidden\" name=\"edit\" value=\"{$row['t_handle']}\">
						<input class=\"btn-medium btn-info\" type=\"submit\" value=\"Edit\">
					</form>
					</td>
					</tr>
					</table>
				</div>
			</div>
			";
	
	
}



// Display form to edit an entry in the address book
if (isset($_GET['edit'])) {
	$edit_query = "SELECT *
					FROM addresses
					WHERE t_handle='{$_GET['edit']}' and owner='$screen_name';
				   ";
	$edit_list = $db->query($edit_query);
	$edit_target = $edit_list->fetch_assoc();

	$edit_entry = "
		  <div class=\"row-fluid\">
		  	<div class=\"span12\">
			  <h3>Edit an entry</h3>
			  <p>
				  <form onsubmit=\"return validateEditForm()\" action=\"index.php\" method=\"get\">
				  Name: <input type=\"text\" name=\"ename\" value=\"{$edit_target['name']}\" id=\"edit_name_field\"><br>
				  Phone number: <input type=\"text\" name=\"ephone\" value=\"{$edit_target['phone']}\" id=\"edit_phone_field\"><br>
				  Twitter handle: <input type=\"text\" name=\"et_handle\" value=\"{$edit_target['t_handle']}\" id=\"edit_t_handle_field\"><br>
				  <input type=\"hidden\" name=\"edit_t_handle\" value=\"{$_GET['edit']}\">
				  <input type=\"submit\" class=\"btn-medium btn-success\" value=\"Change\">
			  </form>
			  </p>
			</div>
		  </div>
		 ";
	unset($_GET['edit']);
}


$add_entry = '
			<div class="row-fluid">
				<div class="span12">
					<h3>Add an entry</h3>
					<p>
					<form onsubmit="return validateAddForm()" action="index.php" method="get" >
						Name: <input type="text" name="fname" id="add_name_field"><br>
						Phone number: <input type="text" name="fphone" id="add_phone_field"><br>
						Twitter handle: <input type="text" name="ft_handle" id="add_t_handle_field"><br>
						<input id="add_submit" class="btn-medium btn-success" type="submit" value="Add">
					</form>
					</p>
				</div>
			</div>

		
		
		
		
		';

/* Include HTML decor to display on the page */
include('html.inc');