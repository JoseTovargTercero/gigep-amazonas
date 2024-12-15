<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');
if (!$_SESSION["u_nivel"]) {
  header("Location: ../index.php");
}

$id_o = $_GET["i"];
$_jecutado  = contar("SELECT count(*) FROM `go_tareas` WHERE `id_operacion`='$id_o' AND status='1'");
$_endiente  = contar("SELECT count(*) FROM `go_tareas` WHERE `id_operacion`='$id_o' AND status='0'");

?>
<html style="    overflow: hidden;">

<head>
  <meta charset="utf-8" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />


</head>

<body style="background-color: #fff !important;">
  <section style="height: 250px;" id="chartdiv"></section>
  <div class="overMark"></div>

  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>

  <script src="../../assets/vendor/amcharts5/index.js"></script>
  <script src="../../assets/vendor/amcharts5/percent.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Animated.js"></script>


  <script>
    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("chartdiv");


    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
      am5themes_Animated.new(root)
    ]);


    // Create chart
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
    var chart = root.container.children.push(am5percent.PieChart.new(root, {
      layout: root.verticalLayout,
      innerRadius: am5.percent(80)
    }));



    // Create series
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
    var series = chart.series.push(am5percent.PieSeries.new(root, {
      valueField: "value",
      categoryField: "category",
      alignLabels: false
    }));



    series.labels.template.setAll({
      textType: "circular",
      centerX: 0,
      centerY: 0
    });

    series.ticks.template.setAll({
      forceHidden: true
    });


    // Set data
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
    series.data.setAll([{
        value: <?php echo $_jecutado ?>,
        category: "Ejecutado"
      },
      {
        value: <?php echo $_endiente ?>,
        category: "Pendiente"
      },
    ]);


    // Create legend
    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
    var legend = chart.children.push(am5.Legend.new(root, {
      centerX: am5.percent(50),
      x: am5.percent(50),
      marginTop: 15,
      marginBottom: 15,
    }));



    // Play initial series animation
    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
    series.appear(1000, 100);
  </script>
</body>

</html>