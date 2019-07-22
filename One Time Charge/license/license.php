<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

require_once '../vendors/stripe-php/init.php';
class License {
    private $isValid = false;
    private $stripeKey = "YOUR_SECRET_KEY"; // #1
    private $trial_file = '../license/trial-expire.php';
    private $stripe_charge_id = '../license/stripe-user.php';
    private $phpExit = '<?php exit(); ?>';
    public function __construct() {
        $this->isValid = false;
    }

    function isValid() {
        if (file_exists($this->stripe_charge_id) == false && file_exists($this->trial_file) == false) {
            $this->isValid = false;
            return $this->isValid;
        }
        if (file_exists($this->stripe_charge_id) == true) {
            $chargeId = file_get_contents($this->stripe_charge_id);
            $chargeId = str_replace($phpExit, '', $chargeId);
            if ($chargeId != null) {
                \Stripe\Stripe::setApiKey($this->stripeKey);
                $charge = \Stripe\Charge::retrieve($chargeId);
                error_log(json_encode($charge));
                if ($charge->status == 'succeeded') {
                    $this->isValid = true;
                } else {
                    $this->isValid = false;
                }
                return $this->isValid;
            }
        }

        if (file_exists($this->trial_file) == true){
            $time = file_get_contents('../license/trial-expire.php');
            $time = str_replace($phpExit, '', $time);
            if($time > time()){
                $this->isValid = true;
            }
            return $this->isValid;
        }
        return $this->isValid;
    }

    function buy($email, $source) {
        if (!$this->isValid() || file_exists($this->stripe_charge_id) == false) {
           
            \Stripe\Stripe::setApiKey($this->stripeKey); //#1
            try
            {
               
                $customer = \Stripe\Customer::create([
                    'email' => $email,
                    'source' => $source,
                ]);
                file_put_contents("error_log.php", $customer);

                $charge = \Stripe\Charge::create([
                  'amount' => 2500,
                  'currency' => 'SGD',
                  'customer' => $customer->id,
                  //'source' => $source,
                  'receipt_email' => $email
                ]);

                error_log(json_encode($charge));
                if ($charge->id != null) {
                    file_put_contents($this->stripe_charge_id, $phpExit . $charge->id);
                }
            } catch (Exception $e) {
                error_log(json_encode($e));
                file_put_contents("error_log2.php", $e);
                return null;
            }
        }
    }

    function deactivate() {
        if ($this->isValid()) {
            // TODO:
            // Call to your service to de-activate this account
            // In this sample code, we will check with Stripe server

            if (file_exists($this->stripe_subscription_id) == true) {
                $subscriptionId = file_get_contents($this->stripe_subscription_id);
                $subscriptionId = str_replace($phpExit, '', $subscriptionId);
                if ($subscriptionId != null) {
                    \Stripe\Stripe::setApiKey($this->stripeKey);
                    $subscription = \Stripe\Subscription::retrieve($subscriptionId);
                    if ($subscription->ended_at == null) {
                        $subscription->cancel();
                    }
                }
            }
        }
    }
}
?>
