<?php
require '../license/license.php';
require 'callAPI.php';
require 'admin_token.php';

$baseUrl = getMarketplaceBaseUrl();
$packageId = getPackageID();

$licence = new License();
if (!$licence->isValid()) {
    ?>
<!-- Your plug-in's index.html -->
<?php
} else {
    $location = $baseUrl . '/admin/plugins/' . $packageId . '/index.php';
    header('Location: ' . $location);
}
?>
