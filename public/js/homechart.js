const url = "http://127.0.0.1:8000/admin/counts";

function getFromAPI(url, callback){
    var obj;
    fetch(url)
      .then(res => res.json())
      .then(data => obj = data)
      .then(() => callback(obj))
}
  
getFromAPI(url, buildChart);
  

function buildChart(data) {
    var options = {
        chart: {
            type: 'area'
        },
        series: [{
            name: 'تعداد',
            data: [data.songsCount, data.usersCount, data.artistsCount, data.albumsCount]
        }],
        xaxis: {
            categories: ["موسیقی ها", "کاربران", "هنرمندان", "آلبوم ها"]
        }
    }
    
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    
    chart.render();
}
