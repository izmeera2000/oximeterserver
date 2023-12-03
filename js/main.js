

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


function indexchart() {
  function replay() {
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "db.php", true);

    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const value1 = [];
        const value2 = [];
        const value3 = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          value1.push(data[i]["gas"]);
          value2.push(data[i]["kelembapan"]);
          value3.push(data[i]["suhu"]);
        }

        // mainChart1.data.labels = labelsc;
        // mainChart1.data.datasets[0].data = bpm;
        // mainChart1.update();
        // mainChart2.data.labels = labelsc;
        // mainChart2.data.datasets[0].data = o2;
        // mainChart2.update();
        suhuchart.data.datasets[0].needleValue = value3[0];
        suhuchart.update();
        kelembapanchart.data.datasets[0].needleValue = value2[0];
        kelembapanchart.update();
        gaschart.data.datasets[0].needleValue = value1[0];
        gaschart.update();
        //  console.log(suhuchart.data.datasets[0].needleValue);
      }
    };
    xhttp.send();
  }

  //gaugeNeedle
  const gaugeNeedle3 = {
    id: "gaugeNeedle",
    afterDatasetDraw(chart, args, options) {
      const {
        ctx,
        config,
        data,
        chartArea: { top, right, bottom, left, width, height },
      } = chart;
      ctx.save();
      const needleValue = data.datasets[0].needleValue;
      const dataTotal = data.datasets[0].data.reduce((a, b) => a + b, 0);

      var angle = Math.PI + (1 / dataTotal) * needleValue * Math.PI;
      // console.log(angle);
      // console.log(dataTotal);

      const cx = width / 2;
      const cy = chart._metasets[0].data[0].y;

      //needle
      ctx.translate(cx, cy);
      ctx.rotate(angle);
      ctx.beginPath();
      ctx.moveTo(0, -2);
      ctx.lineTo(height - ctx.canvas.offsetTop - 160, 0); // change 160 value if the needle size gets changed
      ctx.lineTo(0, 2);
      ctx.fillStyle = "#444";
      ctx.fill();
      //needle dot
      ctx.translate(-cx, -cy);
      ctx.beginPath();
      ctx.arc(cx, cy, 5, 0, 10);
      ctx.fill();
      ctx.restore();

      //text
      ctx.font = "20px Sans-Serif";
      ctx.fillStyle = "#444";
      ctx.fillText(needleValue + " °C", cx, cy + 50);
      ctx.font = "10px Sans-Serif";

      ctx.textAlign = "center";
      ctx.restore();
    },
  };

  const gaugeNeedle = {
    id: "gaugeNeedle",
    afterDatasetDraw(chart, args, options) {
      const {
        ctx,
        config,
        data,
        chartArea: { top, right, bottom, left, width, height },
      } = chart;
      ctx.save();
      const needleValue = data.datasets[0].needleValue;
      const dataTotal = data.datasets[0].data.reduce((a, b) => a + b, 0);

      var angle = Math.PI + (1 / dataTotal) * needleValue * Math.PI;
      // console.log(angle);
      // console.log(dataTotal);

      const cx = width / 2;
      const cy = chart._metasets[0].data[0].y;

      //needle
      ctx.translate(cx, cy);
      ctx.rotate(angle);
      ctx.beginPath();
      ctx.moveTo(0, -2);
      ctx.lineTo(height - ctx.canvas.offsetTop - 160, 0); // change 160 value if the needle size gets changed
      ctx.lineTo(0, 2);
      ctx.fillStyle = "#444";
      ctx.fill();
      //needle dot
      ctx.translate(-cx, -cy);
      ctx.beginPath();
      ctx.arc(cx, cy, 5, 0, 10);
      ctx.fill();
      ctx.restore();

      //text
      ctx.font = "20px Sans-Serif";
      ctx.fillStyle = "#444";
      ctx.fillText(needleValue + " ppb", cx, cy + 50);
      ctx.font = "10px Sans-Serif";

      ctx.textAlign = "center";
      ctx.restore();
    },
  };

  const gaugeNeedle2 = {
    id: "gaugeNeedle",
    afterDatasetDraw(chart, args, options) {
      const {
        ctx,
        config,
        data,
        chartArea: { top, right, bottom, left, width, height },
      } = chart;
      ctx.save();
      const needleValue = data.datasets[0].needleValue;
      const dataTotal = data.datasets[0].data.reduce((a, b) => a + b, 0);

      var angle = Math.PI + (1 / dataTotal) * needleValue * Math.PI;
      // console.log(angle);
      // console.log(dataTotal);

      const cx = width / 2;
      const cy = chart._metasets[0].data[0].y;

      //needle
      ctx.translate(cx, cy);
      ctx.rotate(angle);
      ctx.beginPath();
      ctx.moveTo(0, -2);
      ctx.lineTo(height - ctx.canvas.offsetTop - 160, 0); // change 160 value if the needle size gets changed
      ctx.lineTo(0, 2);
      ctx.fillStyle = "#444";
      ctx.fill();
      //needle dot
      ctx.translate(-cx, -cy);
      ctx.beginPath();
      ctx.arc(cx, cy, 5, 0, 10);
      ctx.fill();
      ctx.restore();

      //text
      ctx.font = "20px Sans-Serif";
      ctx.fillStyle = "#444";
      ctx.fillText(needleValue + " %", cx, cy + 50);
      ctx.font = "10px Sans-Serif";

      ctx.textAlign = "center";
      ctx.restore();
    },
  };
  // config
  const config = {
    type: "doughnut",
    data: {
      labels: ["Safe", "Risky", "High Risk"],
      datasets: [
        {
          label: "Gauge",
          data: [20, 5, 25],
          backgroundColor: [
            "rgba(255, 206, 86, 0.8)",
            "rgba(34,139,34, 0.8)",
            "rgba(255, 26, 104, 0.8)",
          ],
          needleValue: 0,
          borderColor: "white",
          borderWidth: 2,
          cutout: "95%",
          circumference: 180,
          rotation: 270,
          borderRadius: 5,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
    },
    plugins: [gaugeNeedle3],
  };

  // render init bloconsck
  const suhuchart = new Chart(document.getElementById("suhu"), config);

  // config
  const config2 = {
    type: "doughnut",
    data: {
      labels: ["Safe", "Risky", "High Risk"],
      datasets: [
        {
          label: "Gauge",
          data: [60, 10, 30],
          backgroundColor: [
            "rgba(255, 206, 86, 0.8)",
            "rgba(34,139,34, 0.8)",
            "rgba(255, 26, 104, 0.8)",
          ],
          needleValue: 0,
          borderColor: "white",
          borderWidth: 2,
          cutout: "95%",
          circumference: 180,
          rotation: 270,
          borderRadius: 5,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
    },
    plugins: [gaugeNeedle2],
  };

  // render init bloconsck
  const kelembapanchart = new Chart(
    document.getElementById("kelembapan"),
    config2
  );

  const config3 = {
    type: "doughnut",
    data: {
      labels: ["Safe", "Risky", "High Risk"],
      datasets: [
        {
          label: "Gauge",
          data: [250, 1750, 2000],
          backgroundColor: [
            "rgba(255, 206, 86, 0.8)",
            "rgba(34,139,34, 0.8)",
            "rgba(255, 26, 104, 0.8)",
          ],
          needleValue: 0,
          borderColor: "white",
          borderWidth: 2,
          cutout: "95%",
          circumference: 180,
          rotation: 270,
          borderRadius: 5,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
    },
    plugins: [gaugeNeedle],
  };

  // render init bloconsck
  const gaschart = new Chart(document.getElementById("gas"), config3);
  setInterval(replay, 1000);
}

function suhuchart1(time1,time2) {
  function replay() {
    const xhttp = new XMLHttpRequest();

    if (typeof time1 == 'undefined' && typeof time2 == 'undefined' )  {
      xhttp.open("GET", "db.php?",  true);

    }else{
      xhttp.open("GET", "db.php?time1="+time1+"&time2="+time2,  true);

    }



    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const bpm = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          bpm.push(data[i]["suhu"]);
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
          label: "Suhu",
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
              if (val > 20 && val <= 25) {
                return "green";
              }
              if (val >= 0 && val <= 20) {
                return "yellow";
              }
              if (val >  25) {
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

function gaschart1(time1,time2) {
  function replay() {
    const xhttp = new XMLHttpRequest();

    if (typeof time1 == 'undefined' && typeof time2 == 'undefined' )  {
      xhttp.open("GET", "db.php?",  true);

    }else{
      xhttp.open("GET", "db.php?time1="+time1+"&time2="+time2,  true);

    }



    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const bpm = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          bpm.push(data[i]["gas"]);
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
          label: "Suhu",
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
              if (val > 20 && val <= 25) {
                return "green";
              }
              if (val >= 0 && val <= 20) {
                return "yellow";
              }
              if (val >  25) {
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

function kelembapanchart1(time1,time2) {
  function replay() {
    const xhttp = new XMLHttpRequest();

    if (typeof time1 == 'undefined' && typeof time2 == 'undefined' )  {
      xhttp.open("GET", "db.php?",  true);

    }else{
      xhttp.open("GET", "db.php?time1="+time1+"&time2="+time2,  true);

    }



    xhttp.onload = function () {
      var data = JSON.parse(this.responseText);
      if (data.length !== 0) {
        const labelsc = [];
        const bpm = [];
        for (var i = 0; i < data.length; i++) {
          labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
          bpm.push(data[i]["kelembapan"]);
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
          label: "Suhu",
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
              if (val > 20 && val <= 25) {
                return "green";
              }
              if (val >= 0 && val <= 20) {
                return "yellow";
              }
              if (val >  25) {
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