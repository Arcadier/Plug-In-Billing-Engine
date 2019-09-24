<p align ="center"><img src ="https://theme.zdassets.com/theme_assets/2008942/9566e69f67b1ee67fdfbcd79b1e580bdbbc98874.svg"></p>

## Charge Marketplace Owners for using your Plug-In ##

You can make marketplace administrators pay for your plug-in in 2 ways:
* Subscribe to your Plug-In
* Buy your Plug-In

This tool collects payment from your customers using Stripe only. Long story short, the Plug-In Billing Engine encapsulates your source code and makes it only available after payment has been done

## Pre-requirements ##
* A Stripe Dashboard, you can get one [here](https://stripe.com/en-sg?&utm_campaign=paid_brand-SG_en_Search_Brand_Stripe&utm_medium=cpc&utm_source=google&ad_content=301266036615&utm_term=stripe&utm_matchtype=e&utm_adposition1t1&utm_device=c&gclid=Cj0KCQjw3uboBRDCARIsAO2XcYAvCHyVJVdkKpY27rpxOXvB4kkymiuAAO01RgHZC64I3hNqAqGHbaAaAvsREALw_wcB). Once you have your Stripe account, navigate to `Developers` > `API keys` and take note of your `Publishable` and `Secret` Keys
* Decent knowledge of [Stripe's APIs](https://stripe.com/docs/api)
* Thirst for money :dollar:

<p align ="center"><img width="1416" alt="key" src="https://user-images.githubusercontent.com/6611854/60490138-87662c80-9cd8-11e9-908f-5df8d785f2d1.png"></p>



-----------------------------------------------------------------------------------------------------------------------------

## Subscribe to your plug-in ##

**Back End**

Start by downloading the Subscription Plan folder. To connect your Stripe account to the payments made by the user, navigate to `license` > `license.php`, and insert your Stripe Secret key into the line commented "#1". 

<p align ="center"><img width="789" alt="1" src="https://user-images.githubusercontent.com/6611854/60490114-83d2a580-9cd8-11e9-8564-7ad7f7eff37d.png"></p>

You will also need a `PlanID` to be inserted at the line commented #2. To get this, 
* Go to your Stripe Dashboard
* Navigate to `Billing` > `Products` and then click on `New`. Give your product a name, and unit label or statement descriptor, if necessary, and create the product.

<p align ="center"><img width="1433" alt="2" src="https://user-images.githubusercontent.com/6611854/60490118-83d2a580-9cd8-11e9-96fc-e642c06d862c.png"></p>

This will lead you to the **Pricing Plan Page** for your product. Fill in the necessary details such 
as its Name, Currency, Price per Unit, and Billing interval.

<p align ="center"><img width="1433" alt="3" src="https://user-images.githubusercontent.com/6611854/60490119-846b3c00-9cd8-11e9-85b4-9faaa53e8398.png"><p>

Once your Pricing Plan has been created, click on it and you will be able to retrieve the **Plan ID** that you need.

<p align ="center"><img width="1431" alt="4" src="https://user-images.githubusercontent.com/6611854/60490120-846b3c00-9cd8-11e9-8c81-053de3a34a42.png"></p>

Copy and paste this plan ID back into `license.php` where it says #2.

<p align ="center"><img width="789" alt="5" src="https://user-images.githubusercontent.com/6611854/60490121-8503d280-9cd8-11e9-95a3-e0467d0f6c21.png"></p>

-----------------------------------------------------------------------------------------------------------------------------

**_Front End_**

Back up the root folder, navigate to `admin` > `subscribe.php` and open it. Search for the form tag that is shown in the picture below and you can (and should) customizethe text and form parameters to match the plan you created on Stripe.

 * Text on the main page before the Subscription button
 * `data-key`: Your Stripe Publishable key 
 * `data-name`: Name of your Plug-In
 * `data-description`: Information for the customer
 * `data-image`: Absolute or relative URL of the image that you want to appear on the payment pop-up
 * `data-amount`: The amount (in cents) that the customer is about to pay
 	* This is only a front-end facing number. The amount that gets charged from the customer's card is decided in your Stripe Plan.
 * `data-label`: The text on the pay button. E.g: `Buy` or `Subscribe`

 <p align ="center"><img src="https://user-images.githubusercontent.com/6611854/60490122-8503d280-9cd8-11e9-93a4-81ba50072c8e.png"></p>

<p align ="center"><img width="1369" alt="7" src="https://user-images.githubusercontent.com/6611854/60490123-859c6900-9cd8-11e9-9064-d442a1d180da.png"></p>

<p align ="center"><img width="1323" alt="8" src="https://user-images.githubusercontent.com/6611854/60490126-859c6900-9cd8-11e9-9f2a-c98cdb2242c2.png"></p>

-----------------------------------------------------------------------------------------------------------------------------

**_Adding a Free Trial to your Subscription Plan_**

If you want to add a free trial to your Subscription Plan, **ensure** specifying the duration of this trial on the Front End with the user. 
Navigate to `admin` > `trial.php` and open it. The underlined code in the illustration below follows this logic: time = current time + number of seconds. Therefore, changing the number of seconds would change the duration of the trial. For example, if you want to have a 15-day trial, your line of code should look like:
```php
$time = time() + 15 * 24 * 60 * 60; //(15days * 24 hours * 60 minutes * 60 seconds).
```
In the screenshot below, the trial duration is 30 seconds:

<p align ="center"><img width="1133" alt="trial" src="https://user-images.githubusercontent.com/6611854/60697597-a3a6db00-9f1d-11e9-93a6-89f24c86d723.png"></p>

After using up a trial, the customer will not be able to use it again, unless he/she pays for it. The trial cannot be exploited by uninstalling and re-installing the plug-in.
_It knows._

<div align="center" style="background-color: #f59d9d; opacity: 1.0; border-radius: 30px;">
	<h3 style="color: #ff0000;">IMPORTANT</h3>
	<p style="color: black; font-weight: bold;">Uninstalling the Plug-In will unsubscribe the customer from the subscription plan.</p>
	<p style="color:#000000; font-weight: 600;">Installing the plug-in again will make it ask for payment again.</p>

</div>
-----------------------------------------------------------------------------------------------------------------------------

## One-Time Fee ##

**Back End**

Start by downloading Arcadier’s One Time Charge file. To connect your Stripe account to the payments made by the user, navigate to `license` > `license.php`, and paste your Stripe’s secret key into #1.

<p align="center"><img width="647" alt="9" src="https://user-images.githubusercontent.com/6611854/60490130-8634ff80-9cd8-11e9-9f7e-993d35964cf5.png"></p>

In order to create a One-Time fee that will be charged to your Stripe account, scroll down till you see the function `buy()` and make modifications there. Under the Stripe API call for creating a charge, change the following variables according to what you want to charge (underlined).

<p align="center"><img width="776" alt="10" src="https://user-images.githubusercontent.com/6611854/60490131-8634ff80-9cd8-11e9-8297-cdeabff61d6b.png"></p>

 * `amount`: The amount (in cents) of money you will be charging the user
	 * This is the actual amount that will be charged to the user
 * `currency`: The currency of which the above amount will be charged in

-----------------------------------------------------------------------------------------------------------------------------

**Front End**

Going back to the root folder (One Time Charge), navigate to `admin` > `subscribe.php` and open it. Search for the form tag that is shown in the picture below and make changes you want (underlined).

* Text on the main page before the Payment button
 `data-key`: Your Stripe Publishable key 
 * `data-name`: Name of your Plug-In
 * `data-description`: Information for the customer
 * `data-image`: Absolute or relative URL of the image that you want to appear on the payment pop-up
 * `data-amount`: The amount (in cents) that the customer is about to pay
 	* This is only a front-end facing number. The amount that gets charged from the customer's card is the one that has been specified in `license.php`.
 * `data-label`: The text on the pay button. E.g: `Buy` or `Subscribe`

<p align="center"><img width="870" alt="11" src="https://user-images.githubusercontent.com/6611854/62601355-c4e75680-b923-11e9-8752-4f84885ca00d.PNG"></p>

<p align="center"><img width="1429" alt="12" src="https://user-images.githubusercontent.com/6611854/60490134-86cd9600-9cd8-11e9-9bcb-9d29425e163f.png"><p>

<p align="center"><img width="1339" alt="13" src="https://user-images.githubusercontent.com/6611854/60490136-86cd9600-9cd8-11e9-8e98-532ba167a64a.png"></p>

-----------------------------------------------------------------------------------------------------------------------------

## Where does your Plug-In's source code reside in all this? ##

The Plug-In Billing engine has the same file structure as all other plug-ins should have:
* root
  * admin
    * html
	* css
	* scripts
  * user
    * html
	* css
	* scripts
  * `a.php`
  * `b.php`
  * `c.php`

Let's say you want to create a Premium [Marketplace Report Generator](https://github.com/Arcadier/Marketplace-Report-Generator). 100% of its source code is found in the `admin` folder and subfolders. So the Marketplace Report Generator's 
* `.js` files go in the Plug-In Billing Engine's `admin > scripts` folder. 
* `.css` files go in the Plug-In Billing Engine's `admin > css` folder
* `index.html` file goes inside `admin > index.php` of the Plug-In Billing Engine
	```php
	if($licence->isValid()){
	   ?>
	      <link rel="stylesheet" href="css/style.css">
	      <p>Plug-In Content</p>
	      <script type="text/javascript" src="scripts/scripts.js">
	   <?php
	}
	```

For Plug-Ins that have user side code as well, you should have your scripts and `php` files check for validity of the marketplace owner's license using the `isValid()` function found in `license.php`. 

<img width="1186" alt="14" src="https://user-images.githubusercontent.com/6611854/60490137-86cd9600-9cd8-11e9-8b79-e257b75c3573.png">
