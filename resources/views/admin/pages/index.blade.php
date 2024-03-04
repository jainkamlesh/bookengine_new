@extends('admin.layout.default')
@section('title', 'Hotel System')
@section('content')
<section class="property-wrapper mt-4">
      <h2>Property List</h2>
      <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
        <div class="d-flex position-relative booking-wrapper align-items-center">
          <form autocomplete="off" action="/action_page.php">
            <div class="autocomplete" >
              <input id="myInput" type="text"  placeholder="Search Property" class="prop-inp">
            </div>
          </form>
          <i class="fa fa-search srch-icn-vg" aria-hidden="true"></i>
          <div class="form-group calendar-nav">
            <button id="search" ><i class="fa fa-search" aria-hidden="true"></i></button>
            <img src="images/loader.svg" width="60" id="loader" >
          </div>
        </div>

        <a href="{{route('add.hotel')}}"><button class="btn-add add-btn"><i class="fa fa-plus" aria-hidden="true"></i>Add Hotel</button></a>
      </div>
      <div class="container-fluid">
        <table class="mt-4 pro-table-pg table-hover wrapper">
          <thead>
            <tr class="ft-tr">
              <th></th>
              <th>Hotel Name</th>
              <th>Address</th>
              <th>City</th>
              <th>State</th>
              <th>Contact Name</th>
              <th>Contact Email</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>

            @if($hotelCnt > 0)
            @foreach($hotel as $key => $value)
            <tr>
              <td scope="row" data-label="ID">{{++$key}}</td>
              <td data-label="Hotel Name">{{$value->name}} </td>
              <td data-label="Address">{{$value->address}}</td>
              <td data-label="City">{{$value->city}}</td>
              <td data-label="State">{{$value->state}}</td>
              <td data-label="Contact Name">{{$value->contact_name}}</td>
              <td data-label="Contact Email">{{$value->contact_email}}</td>
              <td data-label="ACTION" class="action-list">
                <div class="d-flex">
                  <a href="{{route('hotel.edit', ['id'=>$value->id])}}" class="icon edit edit-icon">
                    <div class="tooltip">Edit</div>
                    <i class="fa fa-pencil pnsl"></i>
                  </a>
                  <div class="icon edit">
                    <div class="tooltip">View</div>
                    <i class="fa fa-eye btn-success eye-view"></i>
                  </div>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                    <div class="tooltip">Delete</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
      <div class="pagination-btn text-right">
        <a href="">Previous</a>
        <!-- <button href='#' ></button> -->
        <button>Next</button>
      </div>
      <div class="delete-modal-main">
        <div class="modal fade" id="promocodedata">
          <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
            <div class="modal-content">
              <div class="modal-header mt-2">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="coupon">
                  <h5 class="delete-warning">Are you sure want to Delete!</h5>
                  <form action="#" class="mt-4 modal-btn">
                    <button type="button" class="btn btn-default btn-success" data-toggle="modal" data-target="#promocodeapplied" aria-hidden="true" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">No</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="promocodeapplied">
          <div class="modal-dialog modal-dialog-centered promocode_applied" role="document">
            <div class="modal-content">
              <div class="modal-body text-center">
                <div class="couponcode">
                  <img src="images/3-layer.svg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
                </div>
                <div class="promocodeapplied2 mt-3">
                  <h4 class="delete-sucess">Delete Successfully</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@section('footer_content')
<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });
  </script>
  <script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), countries);
</script>
@endsection
 