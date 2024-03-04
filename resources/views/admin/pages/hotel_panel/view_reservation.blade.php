<!DOCTYPE html>
<html lang="en">

<head>
  <title>View Reservation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">

  <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../css/magnific-popup.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/aos.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="../css/datetimepicker.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">

</head>

<body>
<div class="site-wrap">
  <div class="site-navbar">
      <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
          <div class="logo">
            <div class="site-logo">
              <a href="javascript:;" class="js-logo-clone"><i class="fa fa-ravelry" aria-hidden="true" style="font-size: 30px;"></i><span style="color: #ff7c48;"> Channel</span> <span style="color: #543a9b;">Manager</span></a>
            </div>
          </div>
          <div class="d-flex">
            <div class="main-nav d-none d-lg-block">
              <nav class="site-navigation text-right text-md-center" role="navigation">
                <ul class="site-menu js-clone-nav d-none d-lg-block">
                  <li id="close-btn"><i class="fa fa-times js-logo-clone js-menu-toggle close-icn" aria-hidden="true"></i></li>
                  <li><a href="booking.html">Bookings</a></li>
                  <li><a href="add_new_booking.html">Add New Booking</a></li></li>
                  <li><a href="calendar.html">Calendar</a></li></li>
                  <li><a href="bulk_update.html">Bulk Update</a></li>
                  <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">Logs <i class="fa fa-chevron-down" aria-hidden="true"></i>
                      <div class="dropdown-menu logs-drop-menu">
                      <a class="dropdown-item" href="ota_log.html">OTA Logs</a>
                      <a class="dropdown-item" href="api_log.html">API Logs</a>
                    </div>
                    </a>
                  </li>
                  <li class="active">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">Configuration <i class="fa fa-chevron-down" aria-hidden="true"></i>
                      <div class="dropdown-menu logs-drop-menu con">
                        <a class="dropdown-item" href="room_type.html">Room Types</a>
                        <a class="dropdown-item" href="rate_plan.html">Rate Plans</a>
                        <a class="dropdown-item" href="system_mapping.html">System Mapping</a>
                        <a class="dropdown-item" href="ota_channel.html">OTA</a>
                        <a class="dropdown-item" href="channel_mapping.html">OTA Room Mapping</a>
                        <a class="dropdown-item" href="sync_from_ota.html">Full Sync From OTA</a>
                        <a class="dropdown-item" href="sync_to_ota.html">Full Sync To OTA</a>
                        <a class="dropdown-item" href="api_webservice.html">Api webservice</a>
                        <a class="dropdown-item" href="user.html">Users</a>
                    </div>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="icons d-flex align-items-center user-dropdown">
              <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><img src="../images/menu-icn.svg" width="20"></a>
              <div class="dropdown" style="margin-left: 20px;">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><img src="../images/profile.svg" width="30">
                </a>
                <div class="dropdown-menu p-0 view-drop-menu">
                  <a class="dropdown-item" href="#">Logout</a>
                </div>
              </div>
            </div>
          </div>  
        </div>
      </div>
    </div>

    <section class="property-wrapper mt-4">
      <a href="booking.html" class="back-icon" data-toggle="tooltip" title="Back"><img src="../images/chevron.png" class="back-image"></a>
      <h2 class="list-heading">Booking Detail</h2>
    </section>
    <div class="property-wrapper channel-wrapper dashboard-wrapper container my-5">
        <div id="accordion" role="tablist">
          <div class="card">
            <div class="card-header" role="tab" id="headingOne">
              <h5 class="mb-0">
                <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Basic Detail
                </a>
              </h5>
            </div>
            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <ul class="dl-horizontal p-0">
                  <li>
                    <dt>Reservation ID :</dt>
                    <dd id="system_ref_id">10563</dd>
                  </li>
                  <li>
                    <dt>Direct Booking Ref ID :</dt>
                    <dd id="ota_ref_id">0</dd>
                  </li>
                  <li>
                    <dt>Booking Status :</dt>
                    <dd id="ota_ref_id">Confirm</dd>
                  </li>
                  <li>
                    <dt>Check In Date :</dt>
                    <dd id="check_in_date">2020-10-25 ( Sun )</dd>
                  </li>
                  <li>
                    <dt>Check Out Date :</dt>
                    <dd id="check_out_date">2020-10-26 ( Mon )</dd>
                  </li>
                  <li>
                    <dt>No of nights :</dt>
                    <dd id="total_nights">1</dd>
                  </li>
                  <li>
                    <dt>Created At :</dt>
                    <dd id="guest_zipcode">2020-10-25 09:37:58</dd>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card mt-3">
            <div class="card-header" role="tab" id="headingTwo">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Master Guest Information
                </a>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                <ul class="dl-horizontal p-0">
                  <li>
                    <dt>Name :</dt>
                    <dd id="guest_name">Ixod Jdjd</dd>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card mt-3">
            <div class="card-header" role="tab" id="headingThree">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Room Detail
                </a>
              </h5>
            </div>
            <div id="collapseThree" class="collapse show" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row text-center info-table">
                      <div class="col-sm-3">
                        NAME: IXOD JDJD
                      </div>
                      <div class="col-sm-3">
                        ADULT: 1
                      </div>
                      <div class="col-sm-3">
                        CHILD: 0
                      </div>
                      <div class="col-sm-3">
                        INFANT: 0
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <table class="table pro-table-pg edit-table table-hover wrappe">
                      <thead>
                        <tr>
                          <th>Status</th>
                          <th>Stay Date</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="brdr-nonne">
                          <td scope="row" data-label="Status">Check in(Single room - 1)</td>
                          <td data-label="Stay Date">2020-10-25(Special Rate - 14407392 )</td>
                          <td data-label="Amount">50.00 EUR</td>
                        </tr>
                        <tr class="brdr-nonne">
                          <td class="rate-td-res"></td>
                          <td data-label="Stay Date">2020-10-30(Special Rate - 14407392)</td>
                          <td data-label="Amount">50.00 EUR</td>
                        </tr>
                        <tr class="brdr-nonne">
                          <td class="rate-td-res"></td>
                          <td data-label="Stay Date">2020-10-25(Special Rate - 14407392 )</td>
                          <td data-label="Amount">1250.00 EUR</td>
                        </tr>
                        <tr class="price-total brdr-nonne">
                          <th  colspan="2">Tax</th>
                          <th class="text-right ">74.00 EUR</th>
                        </tr>
                        <tr class="price-total">
                          <th  colspan="2">Room Stay Total</th>
                          <th class="text-right ">1424.00 EUR</th>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table pro-table-pg edit-table-sec table-hover wrapper">
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Name</th>
                          <th>No Of Unit</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>
                          <td scope="row" data-label="Code">v</td>
                          <td data-label="Name">v</td>
                          <td data-label="No Of Unit">v</td>
                          <td data-label="Price">v</td>
                      </tbody>
                    </table>
                    <div class="special-request mt-3">
                      <dl>
                        <dt>Special Request :</dt>
                        <dd id="guest_special_requst"></dd>
                      </dl>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="row text-center info-table">
                      <div class="col-sm-3">
                        NAME: IXOD JDJD
                      </div>
                      <div class="col-sm-3">
                        ADULT: 1
                      </div>
                      <div class="col-sm-3">
                        CHILD: 0
                      </div>
                      <div class="col-sm-3">
                        INFANT: 0
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <table class="table pro-table-pg edit-table table-hover wrappe">
                      <thead>
                        <tr>
                          <th>Status</th>
                          <th>Stay Date</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="brdr-nonne">
                          <td scope="row" data-label="Status">Check in(Single room - 1)</td>
                          <td data-label="Stay Date">2020-10-25(Special Rate - 14407392 )</td>
                          <td data-label="Amount">50.00 EUR</td>
                        </tr>
                        <tr class="brdr-nonne">
                          <td class="rate-td-res"></td>
                          <td data-label="Stay Date">2020-10-30(Special Rate - 14407392)</td>
                          <td data-label="Amount">50.00 EUR</td>
                        </tr>
                        <tr class="brdr-nonne">
                          <td class="rate-td-res"></td>
                          <td data-label="Stay Date">2020-10-25(Special Rate - 14407392 )</td>
                          <td data-label="Amount">1250.00 EUR</td>
                        </tr>
                        <tr class="price-total brdr-nonne">
                          <th  colspan="2">Tax</th>
                          <th class="text-right ">74.00 EUR</th>
                        </tr>
                        <tr class="price-total">
                          <th  colspan="2">Room Stay Total</th>
                          <th class="text-right ">1424.00 EUR</th>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table pro-table-pg edit-table-sec table-hover wrapper">
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Name</th>
                          <th>No Of Unit</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>
                          <td scope="row" data-label="Code">v</td>
                          <td data-label="Name">v</td>
                          <td data-label="No Of Unit">v</td>
                          <td data-label="Price">v</td>
                      </tbody>
                    </table>
                    <div class="special-request mt-3">
                      <dl>
                        <dt>Special Request :</dt>
                        <dd id="guest_special_requst"></dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card mt-3">
            <div class="card-header" role="tab" id="headingFour">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Payment Detail
                </a>
              </h5>
            </div>
            <div id="collapseFour" class="collapse show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
              <div class="card-body">
                <ul class="dl-horizontal p-0">
                  <li>
                    <dt>Card Type :</dt>
                    <dd>VI</dd>
                  </li>
                  <li>
                    <dt>Card Holder Name :</dt>
                    <dd>sandro stracuzzi</dd>
                  </li>
                  <li>
                    <dt>Card Number :</dt>
                    <dd id="ota_ref_id">
                      <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                        <button class="view-icon"><i class="fa fa-eye"></i> View Card Number</button>
                      </div>
                    </dd>
                  </li>
                  <li>
                    <dt>Card Expiry Date :</dt>
                    <dd id="check_in_date">01/24</dd>
                  </li>
                  <li>
                    <dt>Card Security :</dt>
                    <dd id="check_out_date">
                      <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                        <button class="view-icon"><i class="fa fa-eye"></i> View Card Number</button>
                      </div>
                    </dd>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card mt-3">
            <div class="card-header" role="tab" id="headingFive">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  Additional Information
                </a>
              </h5>
            </div>
            <div id="collapseFive" class="collapse show" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
            <div class="card-body">
              <ul class="dl-horizontal p-0">
                <li>
                  <dt>Deposited :</dt>
                  <dd>0.00</dd>
                </li>
                <li>
                  <dt>Payment Type :</dt>
                  <dd>Channel Collect</dd>
                </li>
              </ul>
            </div>
            </div>
          </div>
        </div>
        <div class="delete-modal-main">
          <div class="modal fade" id="promocodedata">
            <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
              <div class="modal-content">
                <div class="modal-body re-post">
                  <div class="coupon">
                    <h5 class="delete-warning">Security Key</h5>
                    <input type="text" placeholder="Enter Key" class="form-control">
                    <form action="#" class="mt-4 modal-btn">
                      <button type="button" class="btn btn-default btn-save" data-dismiss="modal">Ok</button>
                      <button type="button" class="btn btn-default btn-close btn-cancel" data-dismiss="modal">Cancel</button>                      
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>


  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/jquery-ui.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.magnific-popup.min.js"></script>
  <script src="../js/aos.js"></script>
  <script src="../js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script >
    $('#datetimepicker2,#datetimepicker3').datepicker({
        weekStart: 0,
        todayBtn: "linked",
        language: "en",
        orientation: "bottom auto",
        keyboardNavigation: false,
        autoclose: true
    });
  </script>
  <script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });

    (function () {
  'use strict'

  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style')
    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    )
    document.head.appendChild(msViewportStyle)
  }

}())
  </script>
</body>

</html>