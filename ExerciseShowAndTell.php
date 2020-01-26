<!DOCTYPE html>
<html>
<head>
   <title>W3.CSS Template</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
   <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
   <style>
      body,h1,h5 {font-family: "Raleway", sans-serif}
      body, html {height: 100%}
      .bgimg {
       background-image: url('gym.jpg');
       min-height: 100%;
       background-position: center;
       background-size: cover;
    }
   </style>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
/* Variables for keeping track of count 
  and placing words from the server into
  an array */
var yoga_cnt = 0;
var yoga_array = [];
var flexibility_cnt = 0;
var flexibility_array = [];
var cardio_cnt = 0;
var cardio_array = [];
var resistance_cnt = 0;
var resistance_array = [];
var upperbody_cnt = 0;
var upperbody_array = [];
var lowerbody_cnt = 0;
var lowerbody_array = [];
/* Open and close table format*/
var tableOpen = ""
tableOpen +='<div class="w3-responsive w3-card-4">';
tableOpen +='<table class="w3-table w3-striped w3-bordered">';
tableOpen +='<thead>';
tableOpen +='<tr class="w3-theme">';
tableOpen +='  <th>Exercise Name</th>';
tableOpen +='  <th>Help Video</th>';
tableOpen +='</tr>';
tableOpen +='</thead><tbody>';
var yogaTableBody = "";
var cardioTableBody = "";
var resistanceTableBody = "";
var tableClose = '</tbody></table>';

//Angular JS creates editible list for user
var app = angular.module("myShoppingList", []); 
app.controller("myCtrl", function($scope) {
    $scope.products = ["Bench Press"];
    $scope.addItem = function () {
        $scope.errortext = "";
        if (!$scope.addMe) {return;}
        if ($scope.products.indexOf($scope.addMe) == -1) {
            $scope.products.push($scope.addMe);
        } else {
            $scope.errortext = "The item is already in your exercise list.";
        }
    }
    $scope.removeItem = function (x) {
        $scope.errortext = "";    
        $scope.products.splice(x, 1);
    }
});

//Used to add to list from arrays of exercises pulled from the server
function AddToMixedList(exercise_item) {
    var scope = angular.element($("#mylist")).scope();
    scope.$apply(function(){
        if (scope.products.indexOf(exercise_item) == -1) {
            scope.products.push(exercise_item);
        } else {
            //Do Nothing
        }
    })
}

/* Shuffle so that the list are not
in the same order every time*/
function shuffle(arra1) {
    var ctr = arra1.length, temp, index;

// While there are elements in the array
    while (ctr > 0) {
// Pick a random index
        index = Math.floor(Math.random() * ctr);
// Decrease ctr by 1
        ctr--;
// And swap the last element with it
        temp = arra1[ctr];
        arra1[ctr] = arra1[index];
        arra1[index] = temp;
    }
    return arra1;
}
//Exercise API accessed
function Get_Exercises(callback)
{
  $.ajax({url: "http://supergenius99.atwebpages.com/ExerciseTracker/GetExercises.php", success: function(result){
      $("#div1").html(result);
      callback();
    }});
}
/*Seperate exercises into different classes*/
function Parse_JSON()
{
  var JSONString = document.getElementById("div1").innerText;
    var OutPutString = "";
    var JSONObject = JSON.parse(JSONString);
    
    for (var key in JSONObject) {
      if (JSONObject.hasOwnProperty(key)) {
        
        if(JSONObject[key]["Class"].toString() == "Yoga")
        {
          //Count all yoga exercises
          yoga_cnt +=1;
          yoga_array.push(JSONObject[key]["Name"].toString());
        }
        else if(JSONObject[key]["Class"].toString() == "Resistance")
        {
          //Count all Resistance exercises
          resistance_cnt +=1;
          resistance_array.push(JSONObject[key]["Name"].toString());
        }
        else if(JSONObject[key]["Class"].toString() == "Cardio")
        {
          //Count all Cardio exercises 
          cardio_cnt +=1;
          cardio_array.push(JSONObject[key]["Name"].toString());
        }
        else if(JSONObject[key]["Class"].toString() == "Flexibility")
        {
          //Count all Flexibility exercises 
          flexibility_cnt +=1;
          flexibility_array.push(JSONObject[key]["Name"].toString());
        }
        OutPutString += JSONObject[key]["Class"] + ", " + JSONObject[key]["Name"] +  "<br/>";
      }
    }
    if (yoga_cnt > 0)
    {
      var yoga_selector = "";
      yoga_selector += ' <button id="generate_yoga_exercise" onclick="generate_yoga_exercise()" class="w3-button w3-black w3-margin-bottom" >Generate </button>&nbsp;&nbsp;</p>';
      yoga_selector += '<p>Select number of yoga exercises<input class="w3-input w3-border" type="number" id="yoga_exercise_cnt" min="1" max="' + yoga_cnt + '" placeholder="Enter Number Of Exercises" required name="yoga_exer_cnt"> <br/>'; 
      
      document.getElementById("yoga_div").innerHTML = yoga_selector;
    }
    if (cardio_cnt > 0)
    {
      var cardio_selector = "";
      cardio_selector += ' <button id="generate_cardio_exercise" onclick="generate_cardio_exercise()" class="w3-button w3-black w3-margin-bottom" >Generate </button>&nbsp;&nbsp;</p>';
      cardio_selector += '<p>Select number of cardio exercises<input class="w3-input w3-border" type="number" id="cardio_exercise_cnt" min="1" max="' + cardio_cnt + '" placeholder="Enter Number Of Cardio" required name="cardio_exer_cnt"> <br/>'; 
      
      document.getElementById("cardio_div").innerHTML = cardio_selector;
    }
    if (resistance_cnt > 0)
    {
      var resistance_selector = "";
      resistance_selector += ' <button id="generate_resistance_exercise" onclick="generate_resistance_exercise()" class="w3-button w3-black w3-margin-bottom" >Generate </button>&nbsp;&nbsp;</p>';
      resistance_selector += '<p>Select number of resistance exercises<input class="w3-input w3-border" type="number" id="resistance_exercise_cnt" min="1" max="' + resistance_cnt + '" placeholder="Enter Number Of Exercises" required name="resistance_exer_cnt"> <br/>'; 
      document.getElementById("resistance_div").innerHTML = resistance_selector;
    }
    
    console.log("yoga_cnt: " + yoga_cnt);
    console.log("resistance_cnt: " + resistance_cnt);
    console.log("cardio_cnt: " + cardio_cnt);
    console.log("flexibility_cnt: " + flexibility_cnt);
    console.log(yoga_array);
    document.getElementById("format_exercise").innerHTML = OutPutString;
    for (var i = 0; i < yoga_array.length; i++) {
       AddToMixedList(yoga_array[i] );
    }
    for (var i = 0; i < resistance_array.length; i++) {
       AddToMixedList(resistance_array[i] );
    }
    for (var i = 0; i < cardio_array.length; i++) {
       AddToMixedList(cardio_array[i] );
    }
}
//randomly generate yoga exercises
function generate_yoga_exercise()
{
  console.log("called generate_yoga_exercise");
  //clear yoga table
  yogaTableBody = "";
  /*
   get the number from the text field
   if number is greater than yoga exercise
     then set out put to the count of the yoga exercise
   if number is less than one 
     then randomly select one yoga exercise
   else
     generate the exercises provided
   */
   yoga_array  = shuffle(yoga_array);
   var numYogaExercises = document.getElementsByName('yoga_exer_cnt')[0].value;
   var yoga_exercise_list = "";
   if(numYogaExercises > yoga_cnt)
   {
     
     //output all in array
     for (var i = 0; i < yoga_array.length; i++) {
       yogaTableBody += "<tr>";
       yogaTableBody += "<td>" + yoga_array[i] + "</td>";
       yogaTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + yoga_array[0] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       yogaTableBody += "</tr>";
       //yoga_exercise_list += yoga_array[i] + " <a href='https://www.youtube.com/results?search_query=" + yoga_array[0] + "' target='_blank'>Click Here For Video Instructions </a> <br/>";
       //Do something
     }
   }
   else if(numYogaExercises < 1)
   {
     //output 1 exercise
     yogaTableBody += "<tr>";
       yogaTableBody += "<td>" + yoga_array[0] + "</td>";
       yogaTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + yoga_array[0] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       yogaTableBody += "</tr>";
     //yoga_exercise_list += yoga_array[0] + " <a href='https://www.youtube.com/results?search_query=" + yoga_array[0] + "' target='_blank'>Click Here For Video Instructions </a> <br/>";
   }
   else 
   {
     //output numYogaExercises
     for (var i = 0; i < numYogaExercises; i++) {
     yogaTableBody += "<tr>";
       yogaTableBody += "<td>" + yoga_array[i] + "</td>";
       yogaTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + yoga_array[0] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       yogaTableBody += "</tr>";
       //yoga_exercise_list += yoga_array[i] + " <a href='https://www.youtube.com/results?search_query=" + yoga_array[i] + "' target='_blank'>Click Here For Video Instructions </a> <br/>";
       //Do something
     }
   }
   yogaTableBody = tableOpen + yogaTableBody + tableClose;
   document.getElementById("yoga_exercise_list").innerHTML = yogaTableBody;
}
//randomly generate cardio exercises
function generate_cardio_exercise()
{
  console.log("called generate_cardio_exercise");
  //clear yoga table
  cardioTableBody = "";
  /*
   get the number from the text field
   if number is greater than yoga exercise
     then set out put to the count of the yoga exercise
   if number is less than one 
     then randomly select one yoga exercise
   else
     generate the exercises provided
   */
   cardio_array  = shuffle(cardio_array);
   var numCardioExercises = document.getElementsByName('cardio_exer_cnt')[0].value;
   var cardio_exercise_list = "";
   if(numCardioExercises > cardio_cnt)
   {
     
     //output all in array
     for (var i = 0; i < cardio_array.length; i++) {
       cardioTableBody += "<tr>";
       cardioTableBody += "<td>" + cardio_array[i] + "</td>";
       cardioTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + cardio_array[i] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       cardioTableBody += "</tr>";
       
     }
   }
   else if(numCardioExercises < 1)
   {
     //output 1 exercise
       cardioTableBody += "<tr>";
       cardioTableBody += "<td>" + cardio_array[0] + "</td>";
       cardioTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + cardio_array[0] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       cardioTableBody += "</tr>";
     //yoga_exercise_list += yoga_array[0] + " <a href='https://www.youtube.com/results?search_query=" + yoga_array[0] + "' target='_blank'>Click Here For Video Instructions </a> <br/>";
   }
   else 
   {
     //output numYogaExercises
     for (var i = 0; i < numCardioExercises; i++) {
       cardioTableBody += "<tr>";
       cardioTableBody += "<td>" + cardio_array[i] + "</td>";
       cardioTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + cardio_array[i] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       cardioTableBody += "</tr>";
       //yoga_exercise_list += yoga_array[i] + " <a href='https://www.youtube.com/results?search_query=" + yoga_array[i] + "' target='_blank'>Click Here For Video Instructions </a> <br/>";
       //Do something
     }
   }
   cardioTableBody = tableOpen + cardioTableBody + tableClose;
   document.getElementById("cardio_exercise_list").innerHTML = cardioTableBody;
}

//randomly generate resistance exercises
function generate_resistance_exercise()
{
  console.log("called generate_resistance_exercise");
  //clear yoga table
  resistanceTableBody = "";
  /*
   get the number from the text field
   if number is greater than yoga exercise
     then set out put to the count of the yoga exercise
   if number is less than one 
     then randomly select one yoga exercise
   else
     generate the exercises provided
   */
   resistance_array  = shuffle(resistance_array);
   var numResistanceExercises = document.getElementsByName('resistance_exer_cnt')[0].value;
   var resistance_exercise_list = "";
   if(numResistanceExercises > cardio_cnt)
   {
     
     //output all in array
     for (var i = 0; i < resistance_array.length; i++) {
       resistanceTableBody += "<tr>";
       resistanceTableBody += "<td>" + resistance_array[i] + "</td>";
       resistanceTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + resistance_array[i] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       resistanceTableBody += "</tr>";
       
     }
   }
   else if(numResistanceExercises < 1)
   {
     //output 1 exercise
       resistanceTableBody += "<tr>";
       resistanceTableBody += "<td>" + resistance_array[0] + "</td>";
       resistanceTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + resistance_array[0] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       resistanceTableBody += "</tr>";
     
   }
   else 
   {
     //output numYogaExercises
     for (var i = 0; i < numResistanceExercises; i++) {
       resistanceTableBody += "<tr>";
       resistanceTableBody += "<td>" + resistance_array[i] + "</td>";
       resistanceTableBody += "<td><a href='https://www.youtube.com/results?search_query=" + resistance_array[i] + "' target='_blank'>Click Here For Video Instructions </a> </td>";
       resistanceTableBody += "</tr>";
       //yoga_exercise_list += yoga_array[i] + " <a href='https://www.youtube.com/results?search_query=" + yoga_array[i] + "' target='_blank'>Click Here For Video Instructions </a> <br/>";
       //Do something
     }
   }
   resistanceTableBody = tableOpen + resistanceTableBody + tableClose;
   document.getElementById("resistance_exercise_list").innerHTML = resistanceTableBody;
}
$(document).ready(function(){
  Get_Exercises(Parse_JSON);
  
});
</script>
</head>
<body>

<div class="bgimg w3-display-container w3-text-white">
  <div class="w3-display-middle w3-jumbo">
    <!--Title/Logo-->
    <p>Exercise Us</p>
  </div>
  <div class="w3-display-topleft w3-container w3-xlarge">
    <p><button onclick="document.getElementById('menu').style.display='block'" class="w3-button w3-black">Generate Exercise</button></p>
    
  </div>
  <div class="w3-display-bottomleft w3-container">
    <p class="w3-xlarge">Need help choosing an exersie?</p>
    <p class="w3-large">Randomly Generate and Exercise Routine</p>
    <p>powered by <a href="http://supergenius99.com" target="_blank">supergenius99.com</a></p>
  </div>
</div>

<!-- Exercise Modal -->
<div id="menu" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom">
    <div class="w3-container w3-black w3-display-container">
      <span onclick="document.getElementById('menu').style.display='none'" class="w3-button w3-display-topright w3-large">x</span>
      <h1>Generate Exercise</h1>
    </div>

    <h2 class="w3-center">Exercises</h2>
    <div class="w3-border">
      <div class="w3-bar w3-theme">
        <!-- various  exercise Resistance, Yoga, Cario, Mixed-->
        <button class="w3-bar-item w3-button testbtn w3-padding-16" onclick="openCity(event,'Resistance')">Resistance</button>
        <button class="w3-bar-item w3-button testbtn w3-padding-16" onclick="openCity(event,'Yoga')">Yoga</button>
        <button class="w3-bar-item w3-button testbtn w3-padding-16" onclick="openCity(event,'Cardio')">Cardio</button>
        <button class="w3-bar-item w3-button testbtn w3-padding-16" onclick="openCity(event,'Mixed')">Mixed</button>
      </div>
      <!-- Resistance Tab -->
      <div id="Resistance" class="w3-container city w3-animate-opacity">
        <h2>Resistance</h2>
        <p>Paris is the capital of France.</p> 
        <p>The Paris area is one of the largest population centers in Europe, with more than 12 million inhabitants.</p>
        
        <div id="resistance_div"> </div>
        <div id="resistance_exercise_list"> </div>
       
        
        
      </div>
      <!-- Yoga Tab -->
      <div id="Yoga" class="w3-container city w3-animate-opacity">
        <h2>Yoga</h2>
        <p>How many exercises would you like to do today?</p>
        <p>
        <div id="yoga_div"> </div>
        <div id="yoga_exercise_list"> </div>
        </p>
      </div>
      </div>
      <!-- Cardio Tab -->
      <div id="Cardio" class="w3-container city w3-animate-opacity">
        <h2>Cardio</h2>
        <p>How many exercises would you like to do today?</p>
        <p>
        <div id="cardio_div"> </div>
        <div id="cardio_exercise_list"> </div>
        </p>
      </div>
      <!-- Custom Mix Tab -->
      <div id="Mixed" class="w3-container city w3-animate-opacity">
        <h2>Custom Mix</h2>
        <div ng-app="myShoppingList" ng-cloak ng-controller="myCtrl" class="w3-card-2 w3-margin" style="max-width:75%;">
  <header class="w3-container w3-light-grey w3-padding-16">
    <h3>My Exercise List</h3>
  </header>
  <ul class="w3-ul">
    
    <li id="mylist" ng-repeat="x in products" class="w3-padding-16">{{x}}  <a id="link-6" ng-href="https://www.youtube.com/results?search_query={{x}}" target="_blank">Watch Video</a><span ng-click="removeItem($index)" style="cursor:pointer;" class="w3-right w3-margin-right">×</span></li>
  </ul>
  <div class="w3-container w3-light-grey w3-padding-16">
    <div class="w3-row w3-margin-top">
      <div class="w3-col s10">
        <input placeholder="Add exercises here" ng-model="addMe" class="w3-input w3-border w3-padding">
      </div>
      <div class="w3-col s2">
        <button ng-click="addItem()" class="w3-btn w3-padding w3-green">Add</button>
      </div>
    </div>
    <p class="w3-text-red">{{errortext}}</p>
  </div>
   
</div>
      </div>
    </div>

  </div>
</div>


<script>
// Side navigation
function w3_open() {
  var x = document.getElementById("mySidebar");
  x.style.width = "100%";
  x.style.fontSize = "40px";
  x.style.paddingTop = "10%";
  x.style.display = "block";
}
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}

// Tabs
function openCity(evt, cityName) {
  var i;
  var x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  var activebtn = document.getElementsByClassName("testbtn");
  for (i = 0; i < x.length; i++) {
    activebtn[i].className = activebtn[i].className.replace(" w3-dark-grey", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " w3-dark-grey";
}

var mybtn = document.getElementsByClassName("testbtn")[0];
mybtn.click();

// Accordions
function myAccFunc(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}

// Slideshows
var slideIndex = 1;

function plusDivs(n) {
  slideIndex = slideIndex + n;
  showDivs(slideIndex);
}

function showDivs(n) {
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length} ;
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}

showDivs(1);

// Progress Bars
function move() {
  var elem = document.getElementById("myBar");   
  var width = 5;
  var id = setInterval(frame, 10);
  function frame() {
    if (width == 100) {
      clearInterval(id);
    } else {
      width++; 
      elem.style.width = width + '%'; 
      elem.innerHTML = width * 1  + '%';
    }
  }
}
</script>
<!-- Hidden divs used store data from the server 
as to not continuously query the database-->
<div id="div1" hidden></div>
<div id="format_exercise" hidden></div>
</body>
</html>

