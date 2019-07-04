<p align="center"><img src="https://theme.zdassets.com/theme_assets/2008942/9566e69f67b1ee67fdfbcd79b1e580bdbbc98874.svg"/></p>

1. [Setting up the Plug-In Billing Engine]()
2. [Setting up a recurring payment to use your Plug-In]()
3. [Setting up a one time fee to use your Plug-In]()
4. [How to set a free trial period?]()
5. [What if a payment is not successful for the recurring payment?]() 

## Setting up the Plug-In Billing Engine ##

This guide is intended to help Developers integrate Stripe to their Plug-Ins. Using this, you can charge your marketplace admins directly on a subscription basis or a one-time fee. This will be a step-by-step guide on how to wrap the Billing Engine's source code around your Plug-In's code.

First thing you will need is a Stripe account. If you do not have a Stripe account, please go to their [homepage](https://stripe.com/en-sg?&utm_campaign=paid_brand-SG_en_Search_Brand_Stripe&utm_medium=cpc&utm_source=google&ad_content=301266036615&utm_term=stripe&utm_matchtype=e&utm_adposition1t1&utm_device=c&gclid=Cj0KCQjw3uboBRDCARIsAO2XcYAvCHyVJVdkKpY27rpxOXvB4kkymiuAAO01RgHZC64I3hNqAqGHbaAaAvsREALw_wcB) and create one. Once you have your Stripe account, take note of your account’s `Publishable key` and `Secret key`. To obtain them, navigate to “Developers” > “API keys” on your Stripe Dashboard. Out of the two keys, you will have to manually reveal your secret key to retrieve it.

<p align="center"><img width="1416" alt="key" src="https://user-images.githubusercontent.com/6611854/60490138-87662c80-9cd8-11e9-908f-5df8d785f2d1.png"></p>

Once you have your Stripe’s publishable key and secret key, hold onto them both as you will need to configure manual settings using these two keys. We will be using the secret key first.

For your individual Plug-In, decide on whether you want to make it a subscription basis or a one-time fee. If you want to have a one-time payment fee on your Plug-In, scroll down till you see “One-Time Fee”. Otherwise, if you want to have a subscription plan on your Plug-In continue reading below.

-----------------------------------------------------------------------------------------------------------------------------

## Setting up a recurring payment to use your Plug-In ##

**_Back End_**

Start by downloading Arcadier’s `Subscription` folder. To connect your Stripe account to the payments made by the user, navigate to “license” > “license.php”, open it, and paste your Stripe Secret key into #1. 

<p align="center"><img width="789" alt="1" src="https://user-images.githubusercontent.com/6611854/60490114-83d2a580-9cd8-11e9-8564-7ad7f7eff37d.png"></p>

In order to create a Subscription plan, go back to your Stripe account, navigate to “Billing” > “Products” and then click on “New”. Give your product a name, and unit label or statement descriptor if necessary, and create the product.

<p align="center"><img width="1433" alt="2" src="https://user-images.githubusercontent.com/6611854/60490118-83d2a580-9cd8-11e9-96fc-e642c06d862c.png"></p>

This will redirect you to the **Pricing Plan Page** for your product. Fill in the necessary details such 
as its Name, Currency, Price per Unit, and Billing interval.

<p align="center"><img width="1433" alt="3" src="https://user-images.githubusercontent.com/6611854/60490119-846b3c00-9cd8-11e9-85b4-9faaa53e8398.png"></p>

Once your Pricing Plan has been created, click on it and you will be able to retrieve the plan ID that you will require.

<p align="center"><img width="1431" alt="4" src="https://user-images.githubusercontent.com/6611854/60490120-846b3c00-9cd8-11e9-8c81-053de3a34a42.png"></p>

Copy and paste this plan ID back into “license.php” where it says #2. You have now connected both your Stripe account to your Subscription Plug-In as well as a payment plan.

<p align="center"><img width="789" alt="5" src="https://user-images.githubusercontent.com/6611854/60490121-8503d280-9cd8-11e9-95a3-e0467d0f6c21.png"></p>

-----------------------------------------------------------------------------------------------------------------------------

**_Front End_**

Going back to the root folder containing all the code for your Subscription Plug-In, navigate to “admin” > “subscribe.php” and open it. Search for the form tag that is shown in the picture below and you will need to change the following variables according to your unique plan (underlined).
	
<p align="center"><img width="1000" alt="6" src="https://user-images.githubusercontent.com/6611854/60490122-8503d280-9cd8-11e9-93a4-81ba50072c8e.png"></p>

 * Text on the main page before the Subscription button
 * Data-key: Your Stripe account’s publishable key (from when you retrieved it earlier)
 * Data-name: Name of your Plug-In
 * Data-description: Details about specific Subscription Plan
 * Data-amount: The value that is ONLY DISPLAYED on the pay button (in cents)
 	* This does not affect the actual cost of the Subscription Plan
 * Data-label: The name of the button
z

<p align="center"><img width="1369" alt="7" src="https://user-images.githubusercontent.com/6611854/60490123-859c6900-9cd8-11e9-9064-d442a1d180da.png"></p>

<p align="center"><img width="1323" alt="8" src="https://user-images.githubusercontent.com/6611854/60490126-859c6900-9cd8-11e9-9f2a-c98cdb2242c2.png"></p>

-----------------------------------------------------------------------------------------------------------------------------

**_Adding a Free Trial to your Subscription Plan_**

If you want to add a free trial to your Subscription Plan, be sure to specify the duration of this trial on the Front End with the user. Return back to the root folder containing all the code for your Subscription Plug-In and navigate to “admin” > “trial.php” and open it. The underlined code in the illustration below follows this logic: time = current time + number of seconds. Therefore, changing the number of seconds would change the duration of the trial. For example, if you want to have a 15-day trial, your line of code should look like: 
$time = time() + 15 * 24 * 60 * 60; (15days * 24 hours * 60 minutes * 60 seconds).

<p align="center"><img width="567" alt="trial - need to update" src="https://user-images.githubusercontent.com/6611854/60636017-64a65600-9e47-11e9-9375-2e7908271703.png"></p>

-----------------------------------------------------------------------------------------------------------------------------

## One-Time Fee ##

**_Back End_**

Start by downloading Arcadier’s Charge file containing the internal Stripe Plug-In that you will be implementing. To connect your Stripe account to the payments made by the user, navigate to “license” > “license.php”, open it, and paste your Stripe’s secret key into #1.

<p align="center"><img width="647" alt="9" src="https://user-images.githubusercontent.com/6611854/60490130-8634ff80-9cd8-11e9-9f7e-993d35964cf5.png"></p>

In order to create a One-Time fee that will be charged to your connected Stripe account, scroll down till you see the function “buy” and make modifications there. Under the Stripe API call for creating a charge, change the following variables according to your unique charge (underlined).

<p align="center"><img width="776" alt="10" src="https://user-images.githubusercontent.com/6611854/60490131-8634ff80-9cd8-11e9-8297-cdeabff61d6b.png"></p>

 * Amount: The amount (in cents) of money you will be charging the user
	 * This is the actual amount that will be charged to the user
 * Currency: The currency of which the above amount will be charged in

-----------------------------------------------------------------------------------------------------------------------------

**_Front End_**

Going back to the root folder containing all the code for your Subscription Plug-In, navigate to “admin” > “subscribe.php” and open it. Search for the form tag that is shown in the picture below and you will need to change the following variables according to your unique plan (underlined).

<p align="center"><img width="870" alt="11" src="https://user-images.githubusercontent.com/6611854/60490132-8634ff80-9cd8-11e9-9c7c-f5f2f3e0bf46.png"></p>

 * Text on the main page before the Payment button
 * Data-key: Your Stripe account’s publishable key (from when you retrieved it earlier)
 * Data-name: Name of your Plug-In
 * Data-description: Details about specific Payment Plan
 * Data-amount: The value that is ONLY DISPLAYED on the pay button (in cents)
 	 * This does not affect the actual cost of the One-Time Fee
 * Data-label: The name of the button

<p align="center"><img width="1429" alt="12" src="https://user-images.githubusercontent.com/6611854/60490134-86cd9600-9cd8-11e9-9bcb-9d29425e163f.png"></p>

<p align="center"><img width="1339" alt="13" src="https://user-images.githubusercontent.com/6611854/60490136-86cd9600-9cd8-11e9-8e98-532ba167a64a.png"></p>

-----------------------------------------------------------------------------------------------------------------------------

## Location of the Actual Plug-In you are trying to Sell ##

Now that you have added a payment method (subscription or one-time fee), here is where you add the actual content of the Plug-In you are trying to sell. Whether you are implementing a Subscription Plan or a One-Time Fee, the location of the actual Plug-In itself should remain the same. In your root folder, you should have the same structure as normal Plug-Ins, in that there are three internal directories called "css", "html", and "scripts". However, in the case of an additional Stripe Payment, your "html" file should be empty while your "css" and "scripts" files remain the same. Now, return to your root folder and navigate to “admin” > “index.php” and open it. Your Plug-In's html code should go inside the if-statement just before the else-statement. If you take a look at the illustration below, the if-statement asks if the license is valid (which means paid), and if it is, then it will execute the according Plug-In. Essentially your Plug-In's "index.html" code should go within the indicated box.

<p align="center"><img width="1186" alt="14" src="https://user-images.githubusercontent.com/6611854/60490137-86cd9600-9cd8-11e9-8b79-e257b75c3573.png"></p>

Your Plug-In has Stripe now integrated into it and you may now customize your payment request!

