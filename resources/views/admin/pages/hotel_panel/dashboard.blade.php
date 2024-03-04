@extends('admin.layout.default')
@section('title', 'Dashboard')
@section('content')

<section class="dashboard-wrapper dash-wrapper">
	<div class="container-fluid">
    <ul id="breadcrumb" class="p-0">
      <li><a href="#"><span class="icon icon-beaker"> </span>Dhashboard</a></li>
    </ul>
  </div>

  <div class="container-fluid ">
    <div class="row">
      <div class="col-md-2 mt-2">
        <div class="order-box">
          <div class="ord-icn">
            <i class="fa fa-booking" aria-hidden="true"></i>
          </div>
          <div>
            <h6>Orders</h6>
            <h6>450</h6>
            <!-- <div>
              <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="max-width: 60%">
                <span class="title">60% Increase</span>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="col-md-3 mt-3">
        <div class="order-box orange-box">
          <div class="ord-icn orange-icn">
            <i class="fa fa-suitcase" aria-hidden="true"></i>
          </div>
          <div>
            <h6>Net Banking</h6>
            <h6>155</h6>
            <div>
              <div class="progress orange-bar">
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="max-width: 45%">
                <span class="title">45% Increase</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mt-3">
        <div class="order-box green-box">
          <div class="ord-icn green-icn">
            <i class="fa fa-plus"></i>
          </div>
          <div>
            <h6>Inquiry</h6>
            <h6>45</h6>
            <div>
              <div class="progress green-bar">
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="max-width: 80%">
                <span class="title">80% Increase</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mt-3">
        <div class="order-box blue-box">
          <div class="ord-icn blue-icn">
            <i class="fa fa-plus"></i>
          </div>
          <div>
            <h6>Orders</h6>
            <h6>450</h6>
            <div>
              <div class="progress blue-bar">
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="max-width: 20%">
                <span class="title">20%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mt-4">
        <div class="bar-chart-box">
          <canvas id="myChart2"></canvas>
        </div>
      </div>
      <div class="col-md-6 mt-4">
        <div class="bar-chart-box">
          <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
          </div>
          <canvas id="canvas" style="display: block; width: 1379px; height: 689px;" width="1379" height="689" class="chartjs-render-monitor"></canvas>
        </div>
      </div>
      <div class="col-md-12 mt-4">
        <table class="dash-table-pg pro-table-pg table-hover wrapper">
          <thead>
            <tr class="ft-tr">
              <th><h5 class="modal-title mt-3">Booking Details</h5></th>
            </tr>
          </thead>
          <thead>
            <tr class="ft-tr">
              <th>ROOM TYPE</th>
              <th>RATE PLAN</th>
              <th>CHECK IN</th>
              <th>CHECK OUT</th>
              <th>TOTAL AMOUNT</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="CHECK IN">2020-10-27</td>
              <td data-label="CHECK OUT">2020-10-28</td>
              <td data-label="TOTAL AMOUNT">1250 EUR</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="CHECK IN">2020-10-27</td>
              <td data-label="CHECK OUT">2020-10-28</td>
              <td data-label="TOTAL AMOUNT">1250 EUR</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="CHECK IN">2020-10-27</td>
              <td data-label="CHECK OUT">2020-10-28</td>
              <td data-label="TOTAL AMOUNT">1250 EUR</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-8 mt-4">
        <table class="dash-table-pg pro-table-pg table-hover wrapper">
          <thead>
            <tr class="ft-tr">
              <th><h5 class="modal-title mt-3">Booking Details</h5></th>
            </tr>
          </thead>
          <thead>
            <tr class="ft-tr">
              <th>ROOM TYPE</th>
              <th>RATE PLAN</th>
              <th>CHECK IN</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="CHECK IN">2020-10-27</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="CHECK IN">2020-10-27</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="CHECK IN">2020-10-27</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4 mt-4">
        <table class="dash-table-pg pro-table-pg table-hover wrapper">
          <thead>
            <tr class="ft-tr">
              <th><h5 class="modal-title mt-3">Booking Details</h5></th>
            </tr>
          </thead>
          <thead>
            <tr class="ft-tr">
              <th>ROOM TYPE</th>
              <th>RATE PLAN</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td scope="row" data-label="ROOM TYPE">Single room</td>
              <td data-label="ROOM TYPE">Standard Rate</td>
              <td data-label="ACTION" class="action-list map-div-ss">
                <div class="d-flex">
                  <a href="" class="icon edit edit-icon">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div> 
    </div>
  </div>
</section>

@endsection
@section('footer_content')
 <script>
    var config = {
    type: 'line',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [{
        label: 'APAC RE Index',
        backgroundColor: window.chartColors.backgroundColor="#ff7c48",
        borderColor: window.chartColors.backgroundColor="#ff7c48",
        fill: false,
        data: [
          10,
          20,
          30,
          40,
          100,
          50,
          150
          /*randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor()*/
        ],
      }, {
        label: 'APAC PME',
        backgroundColor: window.chartColors.backgroundColor="#543a9b",
        borderColor: window.chartColors.backgroundColor="#543a9b",
        fill: false,
        data: [
          50,
          300,
          100,
          450,
          150,
          200,
          300
        ],
    
      }]
    },
    options: {
      responsive: true,
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Date'
          },
      
        }],
        yAxes: [{
          display: true,
          //type: 'logarithmic',
          scaleLabel: {
              display: true,
              labelString: 'Index Returns'
            },
            ticks: {
              min: 0,
              max: 500,

              // forces step size to be 5 units
              stepSize: 100
            }
        }]
      }
    }
  };

  window.onload = function() {
    var ctx = document.getElementById('canvas').getContext('2d');
    window.myLine = new Chart(ctx, config);
  };

  document.getElementById('randomizeData').addEventListener('click', function() {
    config.data.datasets.forEach(function(dataset) {
      dataset.data = dataset.data.map(function() {
        return randomScalingFactor();
      });

    });

    window.myLine.update();
  });
  </script>
@endsection

