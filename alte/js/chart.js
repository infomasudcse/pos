

/*
     * BAR CHART
     * ---------
     */

    var bar_data = {
      data : [[1,10], [2,8], [3,4], [4,13], [5,17], [6,9],[7,20],[8,10],[9,15],[10,25],[11,20],[12,15],[13,18],[14,19],[15,9]],
      bars: { show: true }
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: [[1,'1'], [2,'2'], [3,'3'], [4,'4'], [5,'5'], [6,'6'],[7,'7'],[8,'8'],[9,'9'],[10,'10'],[11,'11'],[12,'12'],[13,'13'],[14,'14'],[15,'15']]
      }
    })
    /* END BAR CHART */