</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!--WYSIWYG text editor-->
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script src="js/scripts.js"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Data Set', 'Count'],
            ['Views', <?= $session->getCount(); ?>],
            ['Comments', <?= Comment::countAll(); ?>],
            ['Users', <?= User::countAll(); ?>],
            ['Photos', <?= Photo::countAll(); ?>]
        ]);

        var options = {
            legend: 'none',
            pieSliceText: 'label',
            backgroundColor: 'transparent',
            title: 'Site Data'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>

</body>

</html>
