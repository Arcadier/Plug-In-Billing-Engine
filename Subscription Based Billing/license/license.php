<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

require_once '../vendors/stripe-php/init.php';
class License {
    private $isValid = false;
    private $stripeKey = "sk_test_yFNsENaEKFANhaO80bTCw38R"; // #1
    private $planId = 'plan_FKvAnxKEKUC0xe'; // #2
    private $trial_file = '../license/trial-expire.php';
    private $stripe_subscription_id = '../license/stripe-user.php';
    private $phpExit = '<?php exit(); ?>';
    public function __construct() {
        $this->isValid = false;
    }

    function isValid() {
        if (file_exists($this->trial_file) == false && file_exists($this->stripe_subscription_id) == false) {
            $this->isValid = false;
            return $this->isValid;
        }
        if (file_exists($this->stripe_subscription_id) == true) {
            $subscriptionId = file_get_contents($this->stripe_subscription_id);
            $subscriptionId = str_replace($phpExit, '', $subscriptionId);
            if ($subscriptionId != null) {
                \Stripe\Stripe::setApiKey($this->stripeKey);
                $subscription = \Stripe\Subscription::retrieve($subscriptionId);
                error_log(json_encode($subscription));

                if ($subscription->ended_at != null) {
                    $left = $subscription->ended_at - time();
                    $this->isValid = ($left > 0);
                } else {
                    $this->isValid = true;
                }
                return $this->isValid;
            }
        }
        if (file_exists($this->trial_file) == true) {
            $time = file_get_contents($this->trial_file);
            $time = str_replace($phpExit, '', $time);
            $left = (int) $time - time();
            $this->isValid = ($left > 0);
            return $this->isValid;
        }

        return $this->isValid;
    }

    function activate($email, $source) {
        if (!$this->isValid() || file_exists($this->stripe_subscription_id) == false) {
           
            \Stripe\Stripe::setApiKey($this->stripeKey); //#1
            try
            {
                $customer = \Stripe\Customer::create([
                    'email' => $email,
                    'source' => $source,
                ]);

                $subscription = \Stripe\Subscription::create([
                    'customer' => $customer->id,
                    'items' => [['plan' => $this->planId]],
                    'trial_from_plan' => true,
                ]);
                error_log(json_encode($subscription));
                if ($subscription->id != null) {
                    file_put_contents($this->stripe_subscription_id, $phpExit . $subscription->id);
                }
            } catch (Exception $e) {
                error_log(json_encode($e));
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