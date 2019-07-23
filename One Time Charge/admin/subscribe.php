<?php
require '../license/license.php';
require 'callAPI.php';
require 'admin_token.php';

$baseUrl = getMarketplaceBaseUrl();
$packageId = getPackageID();

$licence = new License();
if (!$licence->isValid()) {
    ?>
<!-- begin header -->
<link href="css/style.css" rel="stylesheet">
<!-- end header -->
<div class="subscription-container">
    <h2>Plug-In Purchase</h2>
    <div class="subscription-content">
        <div class="btn-subscribe">
            <form action="" method="POST" id="subscription-form" enctype="application/x-www-form-urlencoded">
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" 
                data-key="pk_test_Xi2dzgwf92GFsPvucVjGm7I8" 
                data-name="Arcadier Team" 
                data-description="Give me your money" 
                data-amount="2500" 
                data-label="Buy" 
                data-image="https://files.startupranking.com/startup/thumb/57939_de5adf039a36d1a7f7dfe9b6db50c37d9c1981a2_arcadier_m.png">
                </script>
            </form>

            <!-- Uncomment this to enable a Try Me button -->
            <form action="" method="POST" id="subscription-form" enctype="application/x-www-form-urlencoded">
                <a id="continue-trial" href="#">Try me</a>
            </form>

        </div>
          <div class="btn-subscribe">

        </div>
    </div>
</div>
<!-- begin footer -->
<script type="text/javascript" src="scripts/subscription.js"></script>
<!-- end footer -->
<?php
} else {
    $location = $baseUrl . '/admin/plugins/' . $packageId . '/index.php';
    header('Location: ' . $location);
}
?>
