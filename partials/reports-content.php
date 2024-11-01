<?php
    global $wpdb;
    $nmonth = date('m');
    $year = date('Y');
    if( $nmonth > 6){
        for($x=7;$x<13;$x++){                    
            $month = date('F', mktime(0, 0, 0, $x, 10)); // March
            $month_numeric = date('m', mktime(0, 0, 0, $x, 10)); // 01-12
            $shared = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'private' AND post_type = 'sie_shared_product' AND MONTH(post_date)= '".$month_numeric."' AND YEAR(post_date) = '".$year."' ORDER BY post_date ASC");
            $clicked = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'private' AND post_type = 'sie_clicked_product' AND MONTH(post_date)= '".$month_numeric."' AND YEAR(post_date) = '".$year."' ORDER BY post_date ASC");
            $eviews = count($shared) * 338; 
            if( $x == 12 ){
                $string .= "['" . $month . "'," . count($shared) . "," . count($clicked) . "]";
                $string2 .= "['" . $month . "'," . $eviews . "]";
            }
            else{
                $string .= "['" . $month . "'," . count($shared) . "," . count($clicked) . "],";
                $string2 .= "['" . $month . "'," . $eviews . "],";
            }
        }
    }else{
        for($x=1;$x<7;$x++){
            $month = date('F', mktime(0, 0, 0, $x, 10)); // March
            $month_numeric = date('m', mktime(0, 0, 0, $x, 10)); // 01-12
            $shared = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'private' AND post_type = 'sie_shared_product' AND MONTH(post_date)= '".$month_numeric."' AND YEAR(post_date) = '".$year."' ORDER BY post_date ASC");
            $clicked = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'private' AND post_type = 'sie_clicked_product' AND MONTH(post_date)= '".$month_numeric."' AND YEAR(post_date) = '".$year."' ORDER BY post_date ASC");
            $eviews = count($shared) * 338; 
            if( $x == 6 ){
                $string .= "['" . $month . "'," . count($shared) . "," . count($clicked) . "]";
                $string2 .= "['" . $month . "'," . $eviews . "],";
            }
            else{
                $string .= "['" . $month . "'," . count($shared) . "," . count($clicked) . "],";
                $string2 .= "['" . $month . "'," . $eviews . "],";
            }
        }
    }       
?>
<div class="row">
    <div class="col-12 pb-4">
        <h3>Shareit Reports</h3>
    </div>

    <div class="col-sm-12 col-xl-8 pb-3 px-2 pl-lg-2 pr-lg-3 pr-xl-0">      
        <div class="row">            
            <div class="col-md-12">
                <h4 class="font-weight-light pt-5">Traffic Over Time</h4>
                <!-- line chart begin -->
                <div id="line-chart" style="width: 100%; height: 70%"></div>
            </div>
        </div>
        <div class="row">            
            <div class="col-md-12">
                <!-- line chart begin -->
                <div id="view-chart" style="width: 100%; height: 70%"></div>
            </div>
        </div>
    </div>
    <?php require_once SIE_DIR_PATH . '/partials/side-upgrade-content.php'; ?>
</div>



<script type="text/javascript" src="https://www.google.com/jsapi"></script>


<script>    
    google.load("visualization", "1", {packages:["corechart"]});
    function drawChart() {        
        // Define the chart to be drawn.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Shares');
        data.addColumn('number', 'Clicks');
        data.addRows([<?php echo $string; ?>]);        
 
        // Set chart options
        var options = {'title' : 'Average Traffic',
            hAxis: {
                title: 'Month'
            },
            vAxis: {
                title: 'Data Comparison'
            },
            'width':'100%',
            'height':400,
            pointsVisible: true
        };

        // Instantiate and draw the chart.
        var chart = new google.visualization.LineChart(document.getElementById('line-chart'));
        chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(drawChart);

    function drawChart2() {        
        // Define the chart to be drawn.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Estimated Views');
        data.addRows([<?php echo $string2; ?>]);        
 
        // Set chart options
        var options = {'title' : 'Average Traffic',
            hAxis: {
                title: 'Month'
            },
            vAxis: {
                title: 'Data Comparison'
            },
            'width':'100%',
            'height':400,
            pointsVisible: true
        };

        // Instantiate and draw the chart.
        var chart = new google.visualization.LineChart(document.getElementById('view-chart'));
        chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(drawChart2);
</script>
<script>
    jQuery(document).ready(function(){
        $('[data-tooltip="tooltip"]').tooltip();
    });
</script>