<?php $rand = rand(0, 100000000); ?>
<link rel="stylesheet" href="{{url('/')}}/css/t-datepicker.min.css" >
<link rel="stylesheet" href="{{url('/')}}//css/bootstrap/bootstrap.css" >
<script src="{{url('/')}}/js/jquery-3.3.1.min.js"></script>
<script src="{{url('/')}}/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/')}}/js/t-datepicker.min.js"></script>`
<link rel="stylesheet" href="{{url('/')}}/css/widget_style.css">
<script src="{{url('/')}}/js/widget_scripts.js"></script>


<form action="{{ env('APP_URL') }}/Scripts/index.pl" method="GET" id="booking_widget_form">
    <input type="hidden" name="hotel_id" value="">
    <div class="container site-inner stick-btn">
        <div class="search-bar-container_inner mb-4">
            <div class="search-bar-container_top d-flex justify-content-between">
                <div class="search-field search-bar-container_guestsWrapper">
                    <button class="search-bar-container_guests" type="button" data-bs-toggle="collapse" data-bs-target="#guestbox" aria-expanded="false">
                        <span class="search-bar-container_label"><span>Guests</span></span><span class="adult_count_str">2 Adult</span>, <span class="child_count_str">0 Children</span>
                    </button>
                    
                    <div class="collapse flyout-container" id="guestbox" >
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Select Guests</h4>
                            <button class="guests-selection-flyout_closeButton" type="button" data-bs-toggle="collapse" data-bs-target="#guestbox" aria-expanded="false"><img src="{{url('/')}}/images/cancel.png"></button>
                        </div>
                    
                        <div class="card card-body">
                            <div class="dr-adult-qty" style="display: block;">
                                                                    
                                <div class="d-flex justify-content-between align-items-center mb-4 adults-number">
                                    <span class="search-bar-container_label">Adults</span>
                                    <div class="number">
                                        <span class="minus">-</span>
                                        <input type="text" name="no_of_adult" id="no_of_adult" value="2">
                                        <span class="plus">+</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center children-number">
                                    <span class="search-bar-container_label">Children</span>
                                    <div class="number">
                                        <span class="minus">-</span>
                                        <input type="text" name="no_of_child" id="no_of_child" value="0">
                                        <span class="plus"  href="#childage" >+</span>
                                    </div>
                                </div>
                                
                                <div class="child-age pt-4" id="childage1" style="display: none;"><span class="d-inline search-bar-container_label">Child 1 Age</span>
                                    <select name="child_age_1" id="child_age_1">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="child-age pt-4" id="childage2" style="display: none;"><span class="d-inline search-bar-container_label">Child 2 Age</span>
                                    <select name="child_age_2" id="child_age_2">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="child-age pt-4" id="childage3" style="display: none;"><span class="d-inline search-bar-container_label">Child 3 Age</span>
                                    <select name="child_age_3" id="child_age_3">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="child-age pt-4" id="childage4" style="display: none;"><span class="d-inline search-bar-container_label">Child 4 Age</span>
                                    <select name="child_age_4" id="child_age_4">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="child-age pt-4" id="childage5" style="display: none;"><span class="d-inline search-bar-container_label">Child 5 Age</span>
                                    <select name="child_age_5" id="child_age_5">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="child-age pt-4" id="childage6" style="display: none;"><span class="d-inline search-bar-container_label">Child 1 Age</span>
                                    <select name="child_age_6" id="child_age_6">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="button_group text-end p-4">
                            <button class="btn button_link" type="button" data-bs-toggle="collapse" data-bs-target="#guestbox"><span>Cancel</span></button>
                            <button class="btn button_btn button_primary button_sm" type="button" data-bs-toggle="collapse" data-bs-target="#guestbox"><span>Apply</span></button>
                        </div>
                    </div>
                </div>
                
                <div class="t-datepicker">
                      <div class="t-check-in">
                      
                      <button class="search-bar-container_checkIn search-bar-container_selected" type="button" aria-label="Check-in Saturday, July 17, 2021" aria-expanded="true"><span class="search-bar-container_label"><span>Check-in</span></span><span><span>Sat, Jul 17, 2021</span></span></button>
                      
                      </div>
                      
                      <div class="t-check-out">
                      
                      <button class="search-bar-container_checkOut" type="button" aria-label="Check-out Sunday, July 18, 2021" aria-expanded="true"><span class="search-bar-container_label"><span>Check-out</span></span><span>Sun, Jul 18, 2021</span></button>
                      
                      </div>
                </div>

                <div class="button_group text-end p-3">
                    <button class="btn button_btn button_primary button_sm booking_search_button" type="button" datatest="Button"><span>Apply</span></button>
                </div>
            
            </div>
        </div><!-- END SEARCH BOX -->
    </div><!-- END LEFT CONTENT -->
</form>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.t-datepicker').tDatePicker({

        });
    });
</script>
