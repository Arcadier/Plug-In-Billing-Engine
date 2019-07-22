(function() {
    var pathname = (window.location.pathname + window.location.search).toLowerCase();
    var token = commonModule.getCookie('webapitoken');
    const packageVersion = "1.0.1";
    const localstorageLifetime = 86400;
    var hostname = window.location.hostname;
    var scriptSrc = document.currentScript.src;
    var packagePath = scriptSrc.replace('/scripts/subscription.js', '').trim();
    var re = /([a-f0-9]{8}(?:-[a-f0-9]{4}){3}-[a-f0-9]{12})/i;
    var packageId = re.exec(scriptSrc.toLowerCase())[1];
    var customFieldPrefix = packageId.replace(/-/g, "");
    var userId = $('#userGuid').val();
    var getPackageCustomFieldCache = userId + "_" + packageId;

    var apiUrl = packagePath + '/create_subscription.php';
    $('#subscription-form').attr('action', apiUrl);
    
    //Uncomment this if you want the Try Me to work
    if ($('#continue-trial').length) {
        $('#continue-trial').click(function() {
            var apiUrl = packagePath + '/trial.php';
            
            var data = {
                'adminID': userId,
                'packageID':packageId,
                'baseURL':hostname
            };

            $.ajax({
                url: apiUrl,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    console.log(response);
                    if (response > 0) {
                        window.location = 'index.php';
                    }
                    else{
                        if(response == 0){
                            console.log("Trial Used Up");
                        }
                    }
                },
                error: function(){
                    console.log("Error");
                }
            });
        });
    }
})();
