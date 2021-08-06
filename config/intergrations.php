<?php

return 
[
    "data" => array(
    	[
    		"type" => "none",
    		"logo" => "",
    		"name" => "None",
    		"alert" => "",
    		"fields" => []
    	],
    	[
    		"type" => "mailchimp",
    		"logo" => "mailchimp.png",
    		"alert" => "The form will subscribe a new contact or lead to the chosen mailing system. Make sure there is an email field in the form!",
    		"name" => "Mailchimp",
    		"fields" => array(
    			[
    				"name" => "api_key",
    				"type" => "text",
    				"label" => "API Key",
    				"required" => true,
    				"placeholder" => "Your Mailchimp API key"
    			],
    			[
    				"name" => "contact_subscription_status",
    				"type" => "select",
    				"options" => array(
    					[
    						"name" => "Active",
    						"value" => "subscribed",
    					],
    					[
    						"name" => "Awaiting user's confirmation",
    						"value" => "pending",
    					]
    				),
    				"label" => "Contact subscription status",
    				"required" => true,
    				"placeholder" => "Contact subscription status"
    			],
    			[
    				"name" => "mailing_list",
    				"type" => "select",
    				"options" => [],
    				"label" => "Mailing list",
    				"required" => true,
    				"placeholder" => "Mailing list"
    			],
    		)
    	],
    	[
    		"type" => "acellemail",
    		"logo" => "acellemail.png",
    		"name" => "Acellemail",
    		"alert" => "",
    		"fields" => []
    	],
    	
    	
    )

];