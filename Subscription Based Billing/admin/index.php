<?php
require '../license/license.php';
require 'callAPI.php';
require 'admin_token.php';

$baseUrl = getMarketplaceBaseUrl();
$packageId = getPackageID();

$licence = new License();
if ($licence->isValid()) {
    ?>
<!-- begin header-->
<link rel="stylesheet" href="https://arcadierengineers.firebaseapp.com/css/style.css">
<link rel="stylesheet" href="https://arcadierengineers.firebaseapp.com/css/fb-sharing-css.css">
<!--end header-->

<div class="col-sm-9 main-content">
	<h2>Facebook App Config</h2>
    <div id="b" class="cause">
        <div class="inner">
		    <input type="text" id="fbid" placeholder="FB App ID">
			<button class= "btn" id="save-btn">Save</button>
		</div>
	</div>
    <h2>Admin Create a Cause</h2>
    <div id="b" class="cause">
        <div class="inner">
            <input type="text" value="" id="input_field-2">
            <input type="button" value="Create cause" id="create" class="btn">
        </div>
    </div>
    <div id="causes_saved">
        <h2>Causes created</h2>
    </div>
    <table id="table" border="1" style="max-width: 900px;">
        <tr>
            <th> Merchant </th>
            <th id="cause-column" colspan="1" style="text-align:center;"> Causes Supported </th>
        </tr>
    </table>
</div>

<script type="text/javascript" src="https://arcadierengineers.firebaseapp.com/scripts/fbApp.js"></script>
<?php
} else {
    $location = $baseUrl . '/admin/plugins/' . $packageId . '/subscribe.php';
    error_log($location);
    header('Location: ' . $location);
}
?>