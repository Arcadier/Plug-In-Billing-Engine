(function(){
	//var scriptSrc = document.currentScript.src;
    //var packagePath = scriptSrc.replace('/scripts/fbApp.js', '').trim();
    var token = getCookie('webapitoken'); 
    //var re = /([a-f0-9]{8}(?:-[a-f0-9]{4}){3}-[a-f0-9]{12})/i;
    var packageId = "569ec33d-3892-e911-80ea-000d3aa0a08d" //re.exec(scriptSrc.toLowerCase())[1];
    var baseURL = window.location.hostname;
    var fbAppCFCode, creation_response, token, counter, maxspan, marketplaceID, value, autofill;
    var userID = "e1676334-1724-45e3-b5fd-5481a3537b45";//$("#userGuid").val();
	var adminID = "e1676334-1724-45e3-b5fd-5481a3537b45";
	var executed = false;
	var span=1;

///////////////////////////////////////////////////Facebook Configuration begin////////////////////////////////////
    getPackageCustomFields();

	function getPackageCustomFields(){
	    var settings = {
			"url": "https://" + baseURL + "/api/v2/packages/" + packageId + "/custom-field-definitions",
			"method": "GET",
			"success": function (response) {
				var result = response[0].Code;
				$.each(response, function(index, cf_definitions){
					if(cf_definitions.Code.startsWith(packageId.replace(/-/g, ''))){
						fbAppCFCode = cf_definitions.Code;
						autofill = getFbAppID();
						if(autofill != ""){
							document.getElementById("fbid").value = autofill;////////////////////////////////// autofills the input firld if APP ID exists
						}
						else{
							document.getElementById("fbid").setAttribute("placeholder", "Enter Facebook APP ID");
						}
					}
				});
			}
		};
	    $.ajax(settings);
	}

	function getCookie(name){
	    var value = '; ' + document.cookie;
	    var parts = value.split('; ' + name + '=');
	    if (parts.length === 2){ return parts.pop().split(';').shift(); }
	}

	function getFbAppID(){
		var MPCustomFields = {
		  "url": "https://" + baseURL + "/api/v2/marketplaces",
		  "method": "GET",
		  "async": false //otherwise value will be undefined
		};

		$.ajax(MPCustomFields).done(function (response) {
			$.each(response.CustomFields, function(index, fb){
		  		if(fb.Code.startsWith(packageId.replace(/-/g, ''))){
		  			 value = fb.Values[0];
		  		}
		  	});
		});
		return value;
	}

	$("#save-btn").click(function(){ ////////////////////////////////////replaces old APP ID/saves APP ID if used for first time
		var appID = $("#fbid").val();
		if(appID.length != ""){
			var data = {
			    "CustomFields": [
			        {
			            "Code": fbAppCFCode,
			            "Values": [
			                appID
			            ]
			        }
			    ]
			};

			var post = {
			  "url": "https://" + baseURL+ "/api/v2/marketplaces",
			  "method": "POST",
			  "headers": {
			    "Content-Type": "application/json",
			    "Authorization": "Bearer " + token
			  },
			  "data": JSON.stringify(data)
			};

			$.ajax(post).done(function (response) {
				getPackageCustomFields();
				toastr.success("APP ID saved", "Success");
			});
		}
		else {
			toastr.error("The fuck you expect me to do with an empty field", "Seriously?")
		}
	})
	/////////////////////////////////////////////////// Facebook Configuration end ////////////////////////////////////

	/////////////////////////////////////////////////// Cause Dashboard begin//////////////////////////////////////////

	function getmarketplaceinfo(){
		var call = {
		  "url": "https://" + baseURL + "/api/v2/marketplaces",
		  "method": "GET",
		};

		$.ajax(call).done(function (response) {
		  marketplaceID = response.ID;
		});
	}

	function displayCausesSaved(){
		var call_params = {
		  "url": "https://" + baseURL + "/api/v2/marketplaces",
		  "method": "GET",
		};

		$.ajax(call_params).done(function (response) {
			$.each(response.CustomFields, function(index, mp_cause){
				if(mp_cause.Code.startsWith("cause")){
					var cause_name = mp_cause.Values[0];

					var container = document.createElement("div");
						container.setAttribute("class", "display");
					var inner = document.createElement("div");
						inner.setAttribute("class", "inner");
						container.appendChild(inner);
					var p = document.createElement("p");
						p.id = "format";
						p.innerHTML = cause_name;
						inner.appendChild(p);
					document.getElementById("causes_saved").appendChild(container);
				}
			})
		});
	}
	
	function getUserInfo(id, callback) {
        var url = "/api/v2/admins/" + adminID + "/users";
        $.ajax({
            url: url,
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            contentType: 'application/json',
            success: function(response) {
                if (response) {
                    callback(response.Records);
                }
            }
        });
	}

	//display Causes Created by admin
	displayCausesSaved();
    
    //display causes supported by merchnats
    getUserInfo(null, function(userInfo) {
        if (userInfo != undefined) {
            for(var i=0; i<userInfo.length; i++){ //loop through users
            	for(var j=0; j<4; j++){
	            	if(userInfo[i].Roles[j] === "Merchant"){ //select merchants from all users
	            		lastname = userInfo[i].LastName;
	             		firstname = userInfo[i].FirstName;

	            		$.each(userInfo[i].CustomFields, function(index, cf){
	            			if (cf.Code.startsWith("cause")) { //if they chose a cause
	            				if(executed == false){
	             					//span=1;
	             					var table = document.getElementById('table');
	             					var tr = document.createElement("tr");
	             					tr.id = i;
									tr.innerHTML = "" + firstname + " " + lastname + "";
									table.appendChild(tr);
		             				executed = true;
	            				}
	            				value =  cf.Values[0];
			                    var td = document.createElement("td");
			                    td.innerHTML = "\n" + value + "";
			                    document.getElementById(i).appendChild(td);
			                    span++;
			                    if(span>maxspan){
			                    	maxspan = span;
			                    	document.getElementById("cause-column").setAttribute("colspan", maxspan);
			                    }
			            	}
		            	});
		            	//next merchant with cause
		            	executed = false;
		            	maxspan = span;
		            	break;
		            }
	            } 
			}
		}
	});

	//admin creates cause
	$("#create").click(function() {
		//create a custom field for marketplace
		var cf_data = {
			"Name": "Cause",
			"IsMandatory": false,
			"DataInputType": "textfield",
			"ReferenceTable": "Implementations",
			"DataFieldType": "string",
			"IsSearchable": true,
			"IsSensitive": false,
			"Active": true
		};

		var params = {
			"url": "https://" + baseURL + "/api/v2/admins/" + adminID + "/custom-field-definitions",
			"method": "POST",
			"headers": {
				"Content-Type": "application/json",
				"Authorization": "Bearer " + token
			},
			"data": JSON.stringify(cf_data)
		};

		$.ajax(params).done(function(response) {
			creation_response = response;
			getmarketplaceinfo();

			//store the title of the Cause in the custom field
			var data = {
				"ID": marketplaceID,
				"CustomFields": [
					{
						"Code": creation_response.Code,
						"Values": [
							$("#input_field-2").val()
						]
					}
				]
			};
			var mp_params = {
				"url": "https://" + baseURL + "/api/v2/marketplaces",
				"method": "POST",
				"headers": {
					"Content-Type": "application/json",
					"Authorization": "Bearer " + token
				},
				"data": JSON.stringify(data),
			};
			$.ajax(mp_params).done(function(result) {
				toastr.success("Cause Saved in Marketplace", "Great");
				location.reload(true);
			});
		});
	});
	/////////////////////////////////////////////////// Cause Dashboard end//////////////////////////////////////////
})();
