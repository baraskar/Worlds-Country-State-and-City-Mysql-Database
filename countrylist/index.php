<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            .container{
                background: none repeat scroll 0 0 #CCCCCC;
                border: 1px solid #5E822E;
                margin: 10% auto auto;
                padding: 25px 26px;
                width: 310px;
            }
            select {
                border: 2px double #0082FF;
                color: #008080;
                font-family: Georgia;
                font-weight: bolder;
                height: 39px;
                padding: 7px 8px;
                width: 300px;
            }
        </style>
        <script src="jQuery.js" type="text/javascript"></script>
        <script type="text/javascript">
            
            // Change Your home URL..
            home_url = 'http://localhost/countrylist';
            
            /* *
             *     fileName - ajax file name to be called by ajax method.
             *     data - pass the infromation(like location-id , location-type) via data variable.
             *     loadDataToDiv - id of the div to which the ajax responce is to be loaded.
             * */
            function ajax_call(fileName,data, loadDataToDiv) {
                jQuery("#"+loadDataToDiv).html('<option selected="selected">-- -- -- Loding Data -- -- --</option>');

                //  If you are changing counrty, make the state and city fields blank
                if(loadDataToDiv=='state'){
                    jQuery('#city').html('');
                    jQuery('#state').html('');                    
                }
                //  If you are changing state, make the city fields blank
                if(loadDataToDiv=='city'){
                    jQuery('#city').html('');
                }
                
                jQuery.post(home_url + '/' + fileName + '.php', data, function(result) {
                    jQuery('#' + loadDataToDiv).html(result);
                });
            }
        </script>
    </head>
    <body>
        <?php
        // Database connection...
        $hostCon = mysql_connect('localhost', 'root', ''); // Update your hosting details.
        $dbCon = mysql_select_db('countrylist'); // Update your database name.
        // Lets select all countries from our table...
        $sqlAllCountries = "SELECT * FROM `location` WHERE `location_type` =0";
        $sqlAllCountriesResult = mysql_query($sqlAllCountries);
        if ($sqlAllCountriesResult) {
            while ($row = mysql_fetch_object($sqlAllCountriesResult)) {
                $objAllCountries[] = $row;
            }
        }
        ?>
        <div class="container">
            <!--  Lets display all countries in an drop down list           -->
            <select name="country" id="select-country" onchange="ajax_call('ajaxCall',{location_id:this.value,location_type:1}, 'state')">
                <option value="">Select Country</option>
                <?php
                foreach ($objAllCountries AS $CountryDetails) {
                    echo '<option value="' . $CountryDetails->location_id . '">' . $CountryDetails->name . '</option>';
                }
                ?>
            </select>
            <br/><br/>
            <select name="state" id="state" onchange="ajax_call('ajaxCall',{location_id:this.value,location_type:2}, 'city')">
            </select>
            <br/><br/>
            <select name="city" id="city" style="width: 300px;">
            </select>
        </div>
        <div id="loading"></div>
    </body>
</html>

