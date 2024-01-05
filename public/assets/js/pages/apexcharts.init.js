/*
Template Name: Minible - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Apex Chart init js
*/

//  line chart datalabel

function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        if (colors) {
            colors = JSON.parse(colors);
            return colors.map(function (value) {
                var newValue = value.replace(" ", "");
                if (newValue.indexOf(",") === -1) {
                    var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                    if (color) return color;
                    else return newValue;;
                } else {
                    var val = value.split(',');
                    if (val.length == 2) {
                        var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                        rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                        return rgbaColor;
                    } else {
                        return newValue;
                    }
                }
            });
        }
    }
}


var LinechartDatalabelColors = getChartColorsArray("line_chart_datalabel");
if (LinechartDatalabelColors) {
var options = {
    chart: {
      height: 380,
      type: 'line',
      zoom: {
        enabled: false
      },
      toolbar: {
        show: false
      }
    },

    colors: LinechartDatalabelColors,
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: [3, 3],
      curve: 'straight'
    },
    series: [{
      name: "High - 2018",
      data: [26, 24, 32, 36, 33, 31, 33]
    },
    {
      name: "Low - 2018",
      data: [14, 11, 16, 12, 17, 13, 12]
    }
    ],
    title: {
      text: 'Average High & Low Temperature',
      align: 'left'
    },
    grid: {
      row: {
        colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
        opacity: 0.2
      },
      borderColor: '#f1f1f1'
    },
    markers: {
      style: 'inverted',
      size: 6
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
      title: {
        text: 'Month'
      }
    },
    yaxis: {
      title: {
        text: 'Temperature'
      },
      min: 5,
      max: 40
    },
    legend: {
      position: 'top',
      horizontalAlign: 'right',
      floating: true,
      offsetY: -25,
      offsetX: -5
    },
    responsive: [{
      breakpoint: 600,
      options: {
        chart: {
          toolbar: {
            show: false
          }
        },
        legend: {
          show: false
        },
      }
    }]
  }
  
  var chart = new ApexCharts(
    document.querySelector("#line_chart_datalabel"),
    options
  );
  
  chart.render();
  }

  //  line chart datalabel
  var LinechartDashedColors = getChartColorsArray("line_chart_dashed");
  if (LinechartDashedColors) {
  var options = {
    chart: {
      height: 380,
      type: 'line',
      zoom: {
        enabled: false
      },
      toolbar: {
        show: false,
    }
    },
    colors: LinechartDashedColors,
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: [3, 4, 3],
      curve: 'straight',
      dashArray: [0, 8, 5]
    },
    series: [{
        name: "Session Duration",
        data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
      },
      {
        name: "Page Views",
        data: [36, 42, 60, 42, 13, 18, 29, 37, 36, 51, 32, 35]
      },
      {
        name: 'Total Visits',
        data: [89, 56, 74, 98, 72, 38, 64, 46, 84, 58, 46, 49]
      }
    ],
    title: {
      text: 'Page Statistics',
      align: 'left'
    },
    markers: {
      size: 0,

      hover: {
        sizeOffset: 6
      }
    },
    xaxis: {
      categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
        '10 Jan', '11 Jan', '12 Jan'
      ],
    },
    tooltip: {
      y: [{
        title: {
          formatter: function (val) {
            return val + " (mins)"
          }
        }
      }, {
        title: {
          formatter: function (val) {
            return val + " per session"
          }
        }
      }, {
        title: {
          formatter: function (val) {
            return val;
          }
        }
      }]
    },
    grid: {
      borderColor: '#f1f1f1',
    }
}

var chart = new ApexCharts(
document.querySelector("#line_chart_dashed"),
options
);

  chart.render();

}

//   spline_area
var AreachartSplineColors = getChartColorsArray("spline_area");
if (AreachartSplineColors) {
var options = {
    chart: {
        height: 350,
        type: 'area',
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
        width: 3,
    },
    series: [{
        name: 'series1',
        data: [34, 40, 28, 52, 42, 109, 100]
    }, {
        name: 'series2',
        data: [32, 60, 34, 46, 34, 52, 41]
    }],
    colors: AreachartSplineColors,
    xaxis: {
        type: 'datetime',
        categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],                
    },
    grid: {
        borderColor: '#f1f1f1',
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}

var chart = new ApexCharts(
    document.querySelector("#spline_area"),
    options
);

chart.render();

}

// column chart
var BarchartColumnColors = getChartColorsArray("column_chart");
if (BarchartColumnColors) {

    var options = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        dataLabels: {
            enabled: true,
            position: 'top', // top, center, bottom,
            formatter: function (val) {
                return val + "";
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        series: [{
                    name: 'Jurnal Inter',
                    data: [6, 3, 5, 19, 10, 18, 20, 33, 18]
                }, {
                    name: 'Jurnal Nasio',
                    data: [5, 9, 11, 9, 9, 20, 21, 44, 30]
                },{
                    name: 'Prosiding',
                    data: [33, 38, 32, 41, 42, 68, 47, 26, 42]
                },{
                    name: 'Prosiding Nasio',
                    data: [13, 3, 1, 0, 1, 1, 2, 3, 2]
                },
            ],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            
            categories: ['2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023'],
            position: 'down',
            labels: {
                offsetY: 0,
    
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: true
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 1,
                        opacityTo: 1,
                    }
                }
            },
            tooltip: {
                enabled: true,
                offsetY: -35,
            }
        },
        fill: {
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + " Penelitian";
                }
            }
    
        },
        
    }
var chart = new ApexCharts(
    document.querySelector("#column_chart"),
    options
);

chart.render();

}






// column chart with datalabels
var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel");
if (BarchartColumnChartColors) {
var options = {
    chart: {
        height: 350,
        type: 'bar',
        toolbar: {
            show: false,
        }
    },
    plotOptions: {
        bar: {
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
    },
    dataLabels: {
        enabled: true,
        position: 'top', // top, center, bottom,
        formatter: function (val) {
            return val + "";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    series: [{
        name: 'publikasi',
        data: [
            
            8, 14, 15, 15, 17, 22, 38, 39, 56, 42
        ]
    }],
    grid: {
        borderColor: '#f1f1f1',
    },
    xaxis: {
        
        categories: ['2014','2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023'],
        position: 'down',
        labels: {
            offsetY: 0,

        },
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: true
        },
        crosshairs: {
            fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 1,
                    opacityTo: 1,
                }
            }
        },
        tooltip: {
            enabled: true,
            offsetY: -35,
        }
    },
    fill: {
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.25,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [50, 0, 100, 100]
        },
    },
    yaxis: {
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false,
        },
        labels: {
            show: false,
            formatter: function (val) {
                return val + " Penelitian";
            }
        }

    },
    
}

var chart = new ApexCharts(
    document.querySelector("#column_chart_datalabel"),
    options
);

chart.render();

}



// column chart with datalabels
var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel_1");
if (BarchartColumnChartColors) {
var options = {
    chart: {
        height: 350,
        type: 'bar',
        toolbar: {
            show: false,
        }
    },
    plotOptions: {
        bar: {
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
    },
    dataLabels: {
        enabled: true,
        position: 'top', // top, center, bottom,
        formatter: function (val) {
            return val + "";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    series: [{
        name: 'Abdimas',
        data: [8, 14, 15, 15, 17, 22, 38, 39, 56, 42, 8, 14, 15, 15, 17, 22, 38, 39, 56, 42,14, 15, 15, 17,8, 14, 15, 15, 17, 22, 38, 39, 56, 42, 8, 14, 15, 15, 17, 22, 38, 39, 56, 42,14, 15, 15, 17]
    }],
    grid: {
        borderColor: '#f1f1f1',
    },
    xaxis: {
        
        categories: ['2000','2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009','2010', '2011', '2012', '2013',  '2014','2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023','2000','2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009','2010', '2011', '2012', '2013',  '2014','2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023'],
        position: 'down',
        labels: {
            offsetY: 0,

        },
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: true
        },
        crosshairs: {
            fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 1,
                    opacityTo: 1,
                }
            }
        },
        tooltip: {
            enabled: true,
            offsetY: -35,
        }
    },
    fill: {
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.25,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [50, 0, 100, 100]
        },
    },
    yaxis: {
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false,
        },
        labels: {
            show: false,
            formatter: function (val) {
                return val + " Penelitian";
            }
        }

    },
    
}

var chart = new ApexCharts(
    document.querySelector("#column_chart_datalabel_1"),
    options
);

chart.render();

}


// Bar chart
var BarchartBarColors = getChartColorsArray("bar_chart");
if (BarchartBarColors) {
var options = {
    chart: {
        height: 350,
        type: 'bar',
        toolbar: {
            show: false,
        }
    },
    plotOptions: {
        bar: {
            horizontal: true,
        }
    },
    dataLabels: {
        enabled: false
    },
    series: [{
        data: [380, 430, 450, 475, 550, 584, 780, 1100, 1220, 1365]
    }],
    colors: BarchartBarColors,
    grid: {
        borderColor: '#f1f1f1',
    },
    xaxis: {
        categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan', 'United States', 'China', 'Germany'],
    }
}

var chart = new ApexCharts(
    document.querySelector("#bar_chart"),
    options
);

chart.render();

}

// Mixed chart
var LinechartMixedColors = getChartColorsArray("mixed_chart");
if (LinechartMixedColors) {
var options = {
    chart: {
        height: 350,
        type: 'line',
        stacked: false,
        toolbar: {
            show: false
        }
    },
    stroke: {
        width: [0, 2, 4],
        curve: 'smooth'
    },
    plotOptions: {
        bar: {
            columnWidth: '50%'
        }
    },
    colors: LinechartMixedColors,
    series: [{
        name: 'Team A',
        type: 'column',
        data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
    }, {
        name: 'Team B',
        type: 'area',
        data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
    }, {
        name: 'Team C',
        type: 'line',
        data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
    }],
    fill: {
        opacity: [0.85, 0.25, 1],
        gradient: {
            inverseColors: false,
            shade: 'light',
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100]
        }
    },
    labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003', '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'],
    markers: {
        size: 0
    },

    xaxis: {
        type: 'datetime'
    },
    yaxis: {
        title: {
            text: 'Points',
        },
    },
    tooltip: {
        shared: true,
        intersect: false,
        y: {
            formatter: function (y) {
                if (typeof y !== "undefined") {
                    return y.toFixed(0) + " points";
                }
                return y;
  
            }
        }
    },
    grid: {
        borderColor: '#f1f1f1'
    }
  }
  
  var chart = new ApexCharts(
    document.querySelector("#mixed_chart"),
    options
  );

  chart.render();

}


//  Radial chart
var RadiachartRadialColors = getChartColorsArray("radial_chart");
if (RadiachartRadialColors) {
var options = {
    chart: {
        height: 370,
        type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
            dataLabels: {
                name: {
                    fontSize: '22px',
                },
                value: {
                    fontSize: '16px',
                },
                total: {
                    show: true,
                    label: 'Total',
                    formatter: function (w) {
                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                        return 249
                    }
                }
            }
        }
    },
    series: [44, 55, 67, 83],
    labels: ['Computer', 'Tablet', 'Laptop', 'Mobile'],
    colors: RadiachartRadialColors,
    
}

var chart = new ApexCharts(
    document.querySelector("#radial_chart"),
    options
);

chart.render();
}


// pie chart
var PiechartPieColors = getChartColorsArray("pie_chart");
if (PiechartPieColors) {
var options = {
  chart: {
      height: 320,
      type: 'pie',
  }, 
  series: [44, 55, 41, 17],
  labels: ["Jurnal Inter", "Jurnal Nasio", "Prosiding Inter", "Prosiding Nasio"],
  colors: PiechartPieColors,
  legend: {
      show: true,
      position: 'bottom',
      horizontalAlign: 'center',
      verticalAlign: 'middle',
      floating: false,
      fontSize: '14px',
      offsetX: 0
  },
  responsive: [{
      breakpoint: 600,
      options: {
          chart: {
              height: 240
          },
          legend: {
              show: false
          },
      }
  }]

}

var chart = new ApexCharts(
  document.querySelector("#pie_chart"),
  options
);

chart.render();

}

// Donut chart
var DonutchartDonutColors = getChartColorsArray("donut_chart");
if (DonutchartDonutColors) {
var options = {
  chart: {
      height: 320,
      type: 'donut',
  }, 
  series: [44, 55, 41, 17, 15],
  labels: ["Series 1", "Series 2", "Series 3", "Series 4", "Series 5"],
  colors: DonutchartDonutColors,
  legend: {
      show: true,
      position: 'bottom',
      horizontalAlign: 'center',
      verticalAlign: 'middle',
      floating: false,
      fontSize: '14px',
      offsetX: 0
  },
  responsive: [{
      breakpoint: 600,
      options: {
          chart: {
              height: 240
          },
          legend: {
              show: false
          },
      }
  }]

}

var chart = new ApexCharts(
  document.querySelector("#donut_chart"),
  options
);

chart.render();

}