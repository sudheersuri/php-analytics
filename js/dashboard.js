   $("document").ready(function()
   {
        // Load google charts
        google.charts.load('current', {'packages':['corechart']});
        
        google.charts.setOnLoadCallback(drawChart);

        finalarray= "";

        agegroupanalytics();
        
        var snippet = "";
        snippet+=`<option value="agegroup">Age Group</option>`;
        snippet+=`<option value="bookingsource">Booking Source</option>`;
        snippet+=`<option value="gender">Gender Analytics</option>`;
        
        $("#category").html(snippet);
        
        $("#category").change(function()
        {
            var selected=$("#category").val();
            if(selected=="agegroup")
                agegroupanalytics();  
            else if(selected=="bookingsource")
                bookingsourceanalytics();
            else if(selected=="gender")
                genderanalytics();  
        });

            function agegroupanalytics()
            {
                    //get the data from php 
                    $.get("../php/getdata.php?type=1",function(data,status){
                        agedata = JSON.parse(data);
                        myArray = Object.entries(agedata.content);
                        finalarray= [['Task', 'Age group']].concat(myArray);
                        drawChart("Age Group Analytics");
                        $("#analyticstitle").html("Age Group Analytics");
                    });
            }

            function bookingsourceanalytics()
            {
                $.get("../php/getdata.php?type=2",function(data,status){
                  
                    bookingsourcedata = JSON.parse(data);
                    myArray = Object.entries(bookingsourcedata.content);
                    finalarray= [['Task', 'Booking Source']].concat(myArray);
                    drawChart("Booking Source Analytics");
                    $("#analyticstitle").html("Booking Source Analytics");
                });
            }
            function genderanalytics()
            {
                $.get("../php/getdata.php?type=3",function(data,status){
                  
                    bookingsourcedata = JSON.parse(data);
                    myArray = Object.entries(bookingsourcedata.content);
                    finalarray= [['Task', 'Gender']].concat(myArray);
                    drawChart("Gender Analytics");
                    $("#analyticstitle").html("Gender Analytics");
                });
            }

            function drawChart(title) 
            {
             
                var data = google.visualization.arrayToDataTable(finalarray);

                // Optional; add a title and set the width and height of the chart
                var options = {'title':title, 'width':1000, 'height':700};

                // Display the chart inside the <div> element with id="piechart"
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                
                chart.draw(data, options);
            }

   });
   