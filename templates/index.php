<?php 
$headers = apache_request_headers();
if ( !empty($headers['OIDC_CLAIM_email'] ) ) {
	require_once('./service/auth.php');
	$acc = get_accounts();
	$audata_id = '';
	$audata_tk = '';
	if ( !empty( $acc[ $headers['OIDC_CLAIM_email'] ] ) ) {
		$audata_id = $headers['OIDC_CLAIM_email'];
		$audata_tk = $acc[ $headers['OIDC_CLAIM_email'] ]['pass'];
	} else {
		$audata_id = 'guest';
		$audata_tk = 'guest';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no'>
	<title>ePIC Collaboration</title>
	<script>
		window.pnb = {
			"title": "ePIC COLLABORATION",
			"basepath": "/phonebook-mui/client",
			"router": "hash",
			"service": "service/",
			"keepalive-interval": 10,
			"institutions": [
				{ "title": "FULL NAME OF THE INSTITUTION", "field": "name_full", "align": "left", "width": "55%" },
				{ "title": "SHORT NAME", "field": "name_short", "align": "left", "width": "15%" },
				{ "title": "COUNTRY", "field": "country", "align": "left", "width": "15%" },
				{ "title": "REGION", "field": "region", "align": "left", "width": "15%" }
			],
			"members": [
				{ "title": "FIRST NAME", "field": "name_first", "align": "right", "width": "20%" },
				{ "title": "LAST NAME", "field": "name_last", "align": "left", "width": "20%" },
				{ "title": "EMAIL", "field": "email", "align": "left", "width": "20%" },
				{ "title": "INSTITUTION", "field": "institution__name_full", "align": "left", "width": "20%" },
				{ "title": "COUNTRY", "field": "institution__country", "align": "left", "width": "20%" }
			],
			"representatives": [
				{ "title": "ROLE", "field": "member_role", "align": "center", "width": "16.6%" },
				{ "title": "FIRST NAME", "field": "name_first", "align": "right", "width": "16.6%" },
				{ "title": "LAST NAME", "field": "name_last", "align": "left", "width": "16.6%" },
				{ "title": "EMAIL", "field": "email", "align": "left", "width": "16.6%" },
				{ "title": "INSTITUTION", "field": "institution__name_full", "align": "left", "width": "16.6%" },
				{ "title": "COUNTRY", "field": "institution__country", "align": "left", "width": "16.6%" }
			],
			"filter-institutions": {
				"display-fields": [ "id", "ror_id", "name_full", "name_short", "country", "region" ],
				"sort-fields": [ "region", "country", "name_full" ]
			},
			"filter-members": {
				"display-fields": [ "id", "orcid_id", "name_first", "name_last", "email", "institution__name_full" ],
				"sort-fields": [ "institution__name_full", "name_last", "name_first" ]
			},
			"filter-representatives": {
				"display-fields": [ "id", "orcid_id", "member_role", "name_first", "name_last", "email", "institution__name_full", "country" ],
				"sort-fields": [ "institution__name_full", "name_last", "name_first" ]
			},
			"allow-guest-access": 1,
			"xlsx": {
				"institutions-export": "eic-institutions",
				"members-export": "eic-members",
				"representatives-export": "eic-representatives"
			},
			"audata": {
				"id": "<?php echo $audata_id; ?>",
				"tk": "<?php echo $audata_tk; ?>"
			}
		};
		Object.seal(window.pnb);
	</script>
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons&Roboto+Mono:ital@0;1&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"/>
	<style></style>
	<link id="page_favicon" href="favicon.ico" rel="icon" type="image/x-icon" />
	<style id="dynamic-style"></style>
</head>
<body tabindex=-1>
	<div id="app-container"></div>
</body>
</html>
