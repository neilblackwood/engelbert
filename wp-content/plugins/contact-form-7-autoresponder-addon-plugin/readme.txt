=== CF7 AutoResponder Addon ===
Contributors: wpsolutions
Donate link: http://wpsolutions-hq.com/
Tags: autoresponder addon for contact form 7, contact form 7 mailchimp, mailchimp addon for contact form 7, 
contact form 7 autoresponder integration, contact form 7 mailchimp integration 
Requires at least: 3.1
Tested up to: 3.5.2
Stable tag: trunk

Allows automatic addition of people to your MailChimp list after they've sent you a message using a CF7 form.
== Description ==
This useful little plugin currently supports addition of subscribers to MailChimp lists.
The Contact Form 7 AutoResponder Addon plugin allows you to automatically add people to your MailChimp list after they've sent you a message using your CF7 form.
You can either choose to automatically attempt to subscribe people to your list by simply enabling the "Enable Mailchimp List Insertion" in the settings,
OR, you can also add a checkbox to your CF7 form with the "name" parameter set to "mc-subscribe" with a label saying something like "Subscribe Me To Your List". (see below) 

Using a checkbox to give your visitors a choice regarding subscription to your mailing list
===========================================================================================
You can also add a checkbox to your CF7 form with the “name” parameter set to “mc-subscribe” with a label saying something like “Subscribe Me To Your List”.

This will then give your visitors the option of whether they want to subscribe to your list or newsletter or whatever, after submitting the CF7 form.

If this checkbox is present and it is enabled and provided the “Enable Mailchimp List Insertion” is also enabled, the plugin will allow the subscription to occur, otherwise it will not.

If by default you do not have the “mc-subscribe” checkbox in your form and the “Enable Mailchimp List Insertion” is also enabled, then subscription will occur by default.


How to subscribe people to different list names based on the CF7 form
======================================================================
Normally people are subscribed to the global AWeber, GetResponse or MailChimp list names which are specified in the main settings of this plugin.

However if for example you have more than 1 list in your AWeber or GetResponse or MailChimp accounts and you wish to add people the different lists, you can do so with this plugin based on the form you are using.

For example if you have 3 different CF7 forms on your site, you can use each form to add people to 3 separate lists whereby each CF7 form can be configured to specify an autoresponder list name.

To do this you simply need to modify the submit button code of the relevant CF7 form by adding an extra parameter.

For example a typical submit button code for a CF7 form looks like the following:

[submit "Send"]

Now if you wanted to use that particular CF7 form to add someone to a different list from the one specified in the global settings of this addon, you simply need to modify the submit code as follows for the CF7 form you are interested in:

[submit "Send|wpsolutionslist1"]

Note that we've simply added a "pipe" character "|" followed by the list name which in our example is called "wpsolutionslist1" to the name of the button.

The plugin will read the submitted values for the "Your Name" and "Your Email" fields which come from the default CF7 form. 
Note that these fields have the "name" parameter set to:

"your-name"

"your-email".

If you wanted to use a slightly more customized form whereby instead of using just a single name field you wanted to use "first name" and 
"last name" in addition to the email field, then this plugin will also read these fields as long as you use the following "name" settings for these fields:

"your-first-name"

"your-last-name"

"your-email"

As stated earlier, this plugin will also look for a checkbox element in the CF7 form with the name "mc-subscribe". If this checkbox is present
and it is enabled and provided the "Enable Mailchimp List Insertion" is also enabled, the plugin will allow the subscription to occur, otherwise it will not.

If by default you do not have the "mc-subscribe" checkbox in your form and the "Enable Mailchimp List Insertion" is also enabled, then subscription
will occur by default.

The plugin settings also allow for the ability to disable the double opt-in email. Please beware that MailChimp can suspend your account if you overly abuse such a feature.

For more information on this and other plugins, visit the <a href="http://wpsolutions-hq.com/" target="_blank">WPSolutions-HQ Blog</a>.
Post any questions or feedback regarding this plugin at our website here: <a href="http://wpsolutions-hq.com/plugins/contact-form-7-autoresponder-addon/" target="_blank">CF7 AutoResp Addon</a>.

== Installation ==

1. FTP the cf7-autoresponder-addon folder to the /wp-content/plugins/ directory, 

OR, alternatively, 

upload the cf7-autoresponder-addon.zip file from the Plugins->Add New page in the WordPress administration panel.

2. Activate the cf7-autoresponder-addon plugin through the 'Plugins' menu in the WordPress administration panel.

If you encounter any bugs, or have comments or suggestions, please contact the WPSolutions-HQ team on support@wpsolutions-hq.com.


== Frequently Asked Questions ==

= Will this plugin tell me when I have successfully added someone to my MailChimp list? =

The CF7 AutResponder Addon plugin will automatically attempt to add someone to your MC list and it will inform you via a log file if a failure occured during a subscription. 
The subscription actions and results will be taken care of by MailChimp.
The important thing to note is that provided your API Key and list name have been correctly configured, your subscriber will need to opt-in by default by clicking on the 
subscribe link in the email which will be sent from MailChimp.
The plugin also has a setting where you can disable the double opt-in email. Please beware that MailChimp can suspend your account if you abuse such a feature.


= Does this plugin add people my MailChimp list by default or can I ask for their permission? =
As long as you have the enabled the settings and created the approporiate CF7 form with the correct names, this plugin will 
automatically invoke MailChimp to send your visitors an "opt-in" email. It is up to them to accept the opt-in or not.

You can also let your visitors decide at the time of filling in the CF7 form whether they want to subscribe to your list by using a checkbox 
with the name "mc-subscribe" in your CF7 form. In this case, your visitor will receive an opt-in email from MailChimp only if they've enabled
the checkbox in the CF7 form.

The plugin also has a setting where you can disable the double opt-in email. Please beware that MailChimp can suspend your account if you abuse such a feature.
== Screenshots ==

1. Screen shot file screenshot-1.jpg shows Settings menu location of this plugin.
2. Screen shot file screenshot-2.jpg shows the administration page of this plugin.

== Changelog ==
= 1.5 =
* added new functionality to allow people to add subsribers to different autoresponder lists on a per Contact Form 7 basis
* minor changes - fix some broken links

= 1.4 =
*added option to disable mailchimp double opt-in email
*fixed bug where the CF7 form appeared to hang whenever an existing MC subscriber tried to subscribe again

= 1.3 =
* Fixed bug where new version of CF7 (v3.3) broke the checkbox "mc-subscribe" functionality

= 1.2 =
* Fixed bug where new version of CF7 broke the checkbox "mc-subscribe"

= 1.1 =
* added ability for checkbox in the CF7 form to govern whether the visitors wants to allow list subscription
* added a check to ensure that the main CF7 plugin is present and activated

= 1.0 =
* First Release

== Upgrade Notice ==
= 1.4 =
New Feature: added option to disable mailchimp double opt-in email
Bug fix: fixed the CF7 form from appearing to hang whenever an existing MC subscriber tried to subscribe again

= 1.3 =
Bug fix: "mc-subscribe" checkbox functionality has been fixed after newest version of CF7 (v3.3) appeared to break it

= 1.2 =
Bug fix: "mc-subscribe" checkbox functionality has been fixed after newest version of cf7 appeared to break it

= 1.0 =
First Release

For more information on the cf7-autoresponder-addon and other plugins, visit the <a href="http://wpsolutions-hq.com/" target="_blank">WPSolutions-HQ Blog</a>.
Post any questions or feedback regarding this plugin at our website here: <a href="http://wpsolutions-hq.com/plugins/contact-form-7-autoresponder-addon/" target="_blank">cf7-autoresponder-addon</a>.
