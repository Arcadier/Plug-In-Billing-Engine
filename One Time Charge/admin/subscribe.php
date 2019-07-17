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
    <h2>Package Subscription page</h2>
    <div class="subscription-content">
        <div class="btn-subscribe">
            <form action="" method="POST" id="subscription-form" enctype="application/x-www-form-urlencoded">
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="pk_test_Xi2dzgwf92GFsPvucVjGm7I8" data-name="Naseer & Abhinav Choco" data-description="GIve me your fkin money" data-amount="2500" data-label="JUST DO IT" data-image="http://www.mykidsite.com/wp-content/uploads/2015/04/Angry-Baby-Showing-His-Finger-400x600.jpg">
                </script>
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