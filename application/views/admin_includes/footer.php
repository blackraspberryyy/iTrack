<!-- DO NOT REMOVE THIS FOOTER -->
<!-- <footer style = "position:fixed; bottom:-15px; right:5px; background:#fff; text-align: right;">
    <p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
</footer>     -->
</div><!--/.main-->



<script src="<?= base_url() ?>assets/lumino_template/js/easypiechart.js"></script>
<script src="<?= base_url() ?>assets/lumino_template/js/easypiechart-data.js"></script>
<script src="<?= base_url() ?>assets/lumino_template/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url() ?>assets/lumino_template/js/custom.js"></script>

<!--DATETIME PICKER-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.datetimepicker').datetimepicker();
        $('.starttime').datetimepicker();
        $('.endtime').datetimepicker({
            format: 'LT',
            useCurrent: false //Important! See issue #1075
        });


        $(".starttime").on("dp.change", function (e) {
            $('.endtime').data("DateTimePicker").minDate(e.time);
        });
        $(".endtime").on("dp.change", function (e) {
            $('.starttime').data("DateTimePicker").maxDate(e.time);
        });
    });
</script>

<!-- Jquery circle progress bar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script>

</body>
</html>