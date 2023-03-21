/* global Chart, coreui */

/**
 * --------------------------------------------------------------------------
 * CoreUI Boostrap Admin Template (v4.2.2): main.js
 * Licensed under MIT (https://coreui.io/license)
 * --------------------------------------------------------------------------
 */

function coretoast($content) {
  const toastLiveExample = document.getElementById("liveToast");
  const toastcontent = document.getElementById("content");
  toastcontent.innerHTML = $content;
  const toast = new coreui.Toast(toastLiveExample);
  toast.show();
}

// Disable the on-canvas tooltip
Chart.defaults.pointHitDetectionRadius = 1;
Chart.defaults.plugins.tooltip.enabled = false;
Chart.defaults.plugins.tooltip.mode = "index";
Chart.defaults.plugins.tooltip.position = "nearest";
Chart.defaults.plugins.tooltip.external = coreui.ChartJS.customTooltips;
Chart.defaults.defaultFontColor = "#646470";
const random = (min, max) =>
  // eslint-disable-next-line no-mixed-operators
  Math.floor(Math.random() * (max - min + 1) + min);

// eslint-disable-next-line no-unused-vars
// const cardChart1 = new Chart(document.getElementById('card-chart1'), {
//   type: 'line',
//   data: {
//     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//     datasets: [{
//       label: 'My First dataset',
//       backgroundColor: 'transparent',
//       borderColor: 'rgba(255,255,255,.55)',
//       pointBackgroundColor: coreui.Utils.getStyle('--cui-primary'),
//       data: [65, 59, 84, 84, 51, 55, 40]
//     }]
//   },
//   options: {
//     plugins: {
//       legend: {
//         display: false
//       }
//     },
//     maintainAspectRatio: false,
//     scales: {
//       x: {
//         grid: {
//           display: false,
//           drawBorder: false
//         },
//         ticks: {
//           display: false
//         }
//       },
//       y: {
//         min: 30,
//         max: 89,
//         display: false,
//         grid: {
//           display: false
//         },
//         ticks: {
//           display: false
//         }
//       }
//     },
//     elements: {
//       line: {
//         borderWidth: 1,
//         tension: 0.4
//       },
//       point: {
//         radius: 4,
//         hitRadius: 10,
//         hoverRadius: 4
//       }
//     }
//   }
// });

// eslint-disable-next-line no-unused-vars
// const cardChart2 = new Chart(document.getElementById('card-chart2'), {
//   type: 'line',
//   data: {
//     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//     datasets: [{
//       label: 'My First dataset',
//       backgroundColor: 'transparent',
//       borderColor: 'rgba(255,255,255,.55)',
//       pointBackgroundColor: coreui.Utils.getStyle('--cui-info'),
//       data: [1, 18, 9, 17, 34, 22, 11]
//     }]
//   },
//   options: {
//     plugins: {
//       legend: {
//         display: false
//       }
//     },
//     maintainAspectRatio: false,
//     scales: {
//       x: {
//         grid: {
//           display: false,
//           drawBorder: false
//         },
//         ticks: {
//           display: false
//         }
//       },
//       y: {
//         min: -9,
//         max: 39,
//         display: false,
//         grid: {
//           display: false
//         },
//         ticks: {
//           display: false
//         }
//       }
//     },
//     elements: {
//       line: {
//         borderWidth: 1
//       },
//       point: {
//         radius: 4,
//         hitRadius: 10,
//         hoverRadius: 4
//       }
//     }
//   }
// });

// eslint-disable-next-line no-unused-vars
// const cardChart3 = new Chart(document.getElementById('card-chart3'), {
//   type: 'line',
//   data: {
//     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//     datasets: [{
//       label: 'My First dataset',
//       backgroundColor: 'rgba(255,255,255,.2)',
//       borderColor: 'rgba(255,255,255,.55)',
//       data: [78, 81, 80, 45, 34, 12, 40],
//       fill: true
//     }]
//   },
//   options: {
//     plugins: {
//       legend: {
//         display: false
//       }
//     },
//     maintainAspectRatio: false,
//     scales: {
//       x: {
//         display: false
//       },
//       y: {
//         display: false
//       }
//     },
//     elements: {
//       line: {
//         borderWidth: 2,
//         tension: 0.4
//       },
//       point: {
//         radius: 0,
//         hitRadius: 10,
//         hoverRadius: 4
//       }
//     }
//   }
// });

// eslint-disable-next-line no-unused-vars
// const cardChart4 = new Chart(document.getElementById('card-chart4'), {
//   type: 'bar',
//   data: {
//     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March', 'April'],
//     datasets: [{
//       label: 'My First dataset',
//       backgroundColor: 'rgba(255,255,255,.2)',
//       borderColor: 'rgba(255,255,255,.55)',
//       data: [78, 81, 80, 45, 34, 12, 40, 85, 65, 23, 12, 98, 34, 84, 67, 82],
//       barPercentage: 0.6
//     }]
//   },
//   options: {
//     maintainAspectRatio: false,
//     plugins: {
//       legend: {
//         display: false
//       }
//     },
//     scales: {
//       x: {
//         grid: {
//           display: false,
//           drawTicks: false
//         },
//         ticks: {
//           display: false
//         }
//       },
//       y: {
//         grid: {
//           display: false,
//           drawBorder: false,
//           drawTicks: false
//         },
//         ticks: {
//           display: false
//         }
//       }
//     }
//   }
// });

// eslint-disable-next-line no-unused-vars
// const mainChart1 = new Chart(document.getElementById('main-chart'), {
//   type: 'line',
//   data: {
//     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//     datasets: [{
//       label: 'My First dataset',
//       backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--cui-info'), 10),
//       borderColor: coreui.Utils.getStyle('--cui-info'),
//       pointHoverBackgroundColor: '#fff',
//       borderWidth: 2,
//       data: [random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200)],
//       fill: true
//     }]
//   },
//   options: {
//     maintainAspectRatio: false,
//     plugins: {
//       legend: {
//         display: false
//       }
//     },
//     scales: {
//       x: {
//         grid: {
//           drawOnChartArea: false
//         }
//       },
//       y: {
//         ticks: {
//           beginAtZero: true,
//           maxTicksLimit: 5,
//           stepSize: Math.ceil(250 / 5),
//           max: 250
//         }
//       }
//     },
//     elements: {
//       line: {
//         tension: 0.4
//       },
//       point: {
//         radius: 0,
//         hitRadius: 10,
//         hoverRadius: 4,
//         hoverBorderWidth: 3
//       }
//     }
//   }
// });

function indexchart() {
  function replay() {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "db.php", true);

    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const bpm = [];
        const o2 = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          bpm.push(data[i]["bpm"]);
          o2.push(data[i]["o2"]);
        }

        document.getElementById("latestbpm").innerHTML = bpm[0];
        document.getElementById("latesto2").innerHTML = o2[0];

        mainChart1.data.labels = labelsc;
        mainChart1.data.datasets[0].data = bpm;
        mainChart1.update();
        mainChart2.data.labels = labelsc;
        mainChart2.data.datasets[0].data = o2;
        mainChart2.update();
      }
    };
    xhttp.send();
  }

  var ctx = document.getElementById("main-chart1").getContext("2d");

  const mainChart1 = new Chart(document.getElementById("main-chart1"), {
    type: "line",
    data: {
      labels: [],
      datasets: [
        {
          label: "BPM",
          backgroundColor: coreui.Utils.hexToRgba(
            coreui.Utils.getStyle("--cui-info"),
            10
          ),
          // borderColor: coreui.Utils.getStyle('--cui-info'),
          pointHoverBackgroundColor: "#fff",
          borderWidth: 2,
          data: [],
          fill: true,

          segment: {
            borderColor: (ctx) => {
              val = ctx.p0.parsed.y;
              if (val >= 60 && val <= 100) {
                return "green";
              }
              if ((val >100) ) {
                return "yellow";
              } 
              if ((val <60) ){
                return "red";
              }
            },
          },
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            drawOnChartArea: false,
          },
        },
        y: {
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 10,
            stepSize: Math.ceil(250 / 25),
            max: 250,
          },
        },
      },
      elements: {
        line: {},
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3,
        },
      },
    },
  });
  var ctx2 = document.getElementById("main-chart2").getContext("2d");

  const mainChart2 = new Chart(document.getElementById("main-chart2"), {
    type: "line",
    data: {
      labels: [],
      datasets: [
        {
          label: "O2 (%)",
          backgroundColor: coreui.Utils.hexToRgba(
            coreui.Utils.getStyle("--cui-info"),
            10
          ),
          // borderColor: coreui.Utils.getStyle('--cui-info'),
          pointHoverBackgroundColor: "#fff",
          borderWidth: 2,
          data: [],
          fill: true,
          segment: {
            borderColor: (ctx2) => {
              val = ctx2.p0.parsed.y;
              if (val >= 97 && val <= 100) {
                return "green";
              }
              if (val >= 95 && val < 97) {
                return "yellow";
              } else {
                return "red";
              }
            },
          },
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            drawOnChartArea: false,
          },
        },
        y: {
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 10,
            stepSize: Math.ceil(250 / 25),
            max: 250,
          },
        },
      },
      elements: {
        line: {},
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3,
        },
      },
    },
  });

  setInterval(replay, 1000);
}

function bpm1() {
  function replay() {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "db.php", true);

    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const bpm = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          bpm.push(data[i]["bpm"]);
        }

        mainChart1.data.labels = labelsc;
        mainChart1.data.datasets[0].data = bpm;
        mainChart1.update();
      }
    };
    xhttp.send();
  }

  var ctx = document.getElementById("main-chart1").getContext("2d");

  const mainChart1 = new Chart(document.getElementById("main-chart1"), {
    type: "line",
    data: {
      labels: [],
      datasets: [
        {
          label: "BPM",
          backgroundColor: coreui.Utils.hexToRgba(
            coreui.Utils.getStyle("--cui-info"),
            10
          ),
          // borderColor: coreui.Utils.getStyle('--cui-info'),
          pointHoverBackgroundColor: "#fff",
          borderWidth: 2,
          data: [],
          fill: true,

          segment: {
            borderColor: (ctx) => {
              val = ctx.p0.parsed.y;
              if (val >= 60 && val <= 100) {
                return "green";
              }
              if ((val >100) ) {
                return "yellow";
              } 
              if ((val <60) ){
                return "red";
              }
            },
          },
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            drawOnChartArea: false,
          },
        },
        y: {
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 10,
            stepSize: Math.ceil(250 / 25),
            max: 250,
          },
        },
      },
      elements: {
        line: {},
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3,
        },
      },
    },
  });

  setInterval(replay, 1000);
}

function bpm2() {
  function replay() {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "db2.php", true);

    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const bpm = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          bpm.push(data[i]["bpm"]);
        }

        mainChart1.data.labels = labelsc;
        mainChart1.data.datasets[0].data = bpm;
        mainChart1.update();
      }
    };
    xhttp.send();
  }

  var ctx = document.getElementById("main-chart1").getContext("2d");

  const mainChart1 = new Chart(document.getElementById("main-chart1"), {
    type: "line",
    data: {
      labels: [],
      datasets: [
        {
          label: "BPM",
          backgroundColor: coreui.Utils.hexToRgba(
            coreui.Utils.getStyle("--cui-info"),
            10
          ),
          // borderColor: coreui.Utils.getStyle('--cui-info'),
          pointHoverBackgroundColor: "#fff",
          borderWidth: 2,
          data: [],
          fill: true,

          segment: {
            borderColor: (ctx) => {
              val = ctx.p0.parsed.y;
              if (val >= 60 && val <= 100) {
                return "green";
              }
              if ((val >100) ) {
                return "yellow";
              } 
              if ((val <60) ){
                return "red";
              }
            },
          },
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            drawOnChartArea: false,
          },
        },
        y: {
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 10,
            stepSize: Math.ceil(250 / 25),
            max: 250,
          },
        },
      },
      elements: {
        line: {},
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3,
        },
      },
    },
  });

  replay();
}


function o21() {
  function replay() {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "db.php", true);

    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const o2 = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          o2.push(data[i]["o2"]);
        }

        mainChart1.data.labels = labelsc;
        mainChart1.data.datasets[0].data = o2;
        mainChart1.update();
      }
    };
    xhttp.send();
  }

  var ctx = document.getElementById("main-chart1").getContext("2d");

  const mainChart1 = new Chart(document.getElementById("main-chart1"), {
    type: "line",
    data: {
      labels: [],
      datasets: [
        {
          label: "O2",
          backgroundColor: coreui.Utils.hexToRgba(
            coreui.Utils.getStyle("--cui-info"),
            10
          ),
          // borderColor: coreui.Utils.getStyle('--cui-info'),
          pointHoverBackgroundColor: "#fff",
          borderWidth: 2,
          data: [],
          fill: true,

          segment: {
            borderColor: (ctx) => {
              val = ctx.p0.parsed.y;
              if (val >= 90 && val <= 100) {
                return "green";
              }
              if ((val >= 70 && val < 90) || (val > 100 && val <= 120)) {
                return "yellow";
              } else {
                return "red";
              }
            },
          },
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            drawOnChartArea: false,
          },
        },
        y: {
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 10,
            stepSize: Math.ceil(250 / 25),
            max: 250,
          },
        },
      },
      elements: {
        line: {},
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3,
        },
      },
    },
  });

  setInterval(replay, 1000);
}

function o22() {
  function replay() {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "db2.php", true);

    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const o2 = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          o2.push(data[i]["o2"]);
        }

        mainChart1.data.labels = labelsc;
        mainChart1.data.datasets[0].data = o2;
        mainChart1.update();
      }
    };
    xhttp.send();
  }

  var ctx = document.getElementById("main-chart1").getContext("2d");

  const mainChart1 = new Chart(document.getElementById("main-chart1"), {
    type: "line",
    data: {
      labels: [],
      datasets: [
        {
          label: "O2",
          backgroundColor: coreui.Utils.hexToRgba(
            coreui.Utils.getStyle("--cui-info"),
            10
          ),
          // borderColor: coreui.Utils.getStyle('--cui-info'),
          pointHoverBackgroundColor: "#fff",
          borderWidth: 2,
          data: [],
          fill: true,

          segment: {
            borderColor: (ctx) => {
              val = ctx.p0.parsed.y;
              if (val >= 90 && val <= 100) {
                return "green";
              }
              if ((val >= 70 && val < 90) || (val > 100 && val <= 120)) {
                return "yellow";
              } else {
                return "red";
              }
            },
          },
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            drawOnChartArea: false,
          },
        },
        y: {
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 10,
            stepSize: Math.ceil(250 / 25),
            max: 250,
          },
        },
      },
      elements: {
        line: {},
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3,
        },
      },
    },
  });

  replay();
}
// function printdocbpm() {
//   var doc = new jsPDF({ orientation: "p", unit: "mm", format: "a4" });
//   doc.setProperties({
//     title: "Oximeter BPM",
//   });
//   var logo = new Image()
//   logo.src = 'assets/favicon/android-icon-144x144.png'


//   doc.addImage(logo, "png", 20, 20, 40, 40);

//   doc.text(50, 20, "Oximeter");

//   var canvas = document.getElementById("main-chart1");

//   doc.addImage(canvas.toDataURL("image/png"), "png", 20, 50, 170, 80);

//   doc.autoTable({
//     html: "#tablebpm",
//     theme: "grid",  
//     startY: 180,
//   });

//   const blobPDF = doc.output("bloburl", "file.pdf");
//   window.open(blobPDF, "_blank");
// }

//# sourceMappingURL=main.js.map
