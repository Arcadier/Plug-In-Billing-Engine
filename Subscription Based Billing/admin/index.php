<?php
require '../license/license.php';
require 'callAPI.php';
require 'admin_token.php';

$baseUrl = getMarketplaceBaseUrl();
$packageId = getPackageID();

$licence = new License();
if ($licence->isValid()) {
    ?>
<!-- Your plug-in's index.html
<p> Payment done. You can now use the Plug-In</p>
<script>
	toastr.success("Welcome", "Success");
</script> -->
<?php
} else {
    $location = $baseUrl . '/admin/plugins/' . $packageId . '/subscribe.php';
    error_log($location);
    header('Location: ' . $location);
}
?>
