// Responsive menu
function showMenu() {
  var x = document.getElementById("myTopnav");
  var y = document.getElementById("messages");
  if (x.className === "topnav") {x.className += " responsive";y.className = "message-content";}
  else {x.className = "topnav";y.className += " responsive";}
}

// Chatroom refresh
function loadChat() {
  $('#chatroom').load('/chatroom/messages.php');
  $('#privatechatroom').load('/chatroom/private.php');
}
setInterval(() => loadChat(), 3000);

// Chatroom auto scroll
function scrollChat() {
  $("#chatroom").animate({ scrollTop: $('#chatroom').prop("scrollHeight") + 9999}, 200);
}
function scrollPrivateChat() {
  $("#privatechatroom").animate({ scrollTop: $('#privatechatroom').prop("scrollHeight") + 9999}, 200);
}
$(document).ready(function(){
  loadChat();
  scrollChat();
  scrollPrivateChat();

// Search function
  $("#search").keyup(function(){
    var name = $('#search').val();
    if (name === "") {$("#display").html("");}
    else {
      $.ajax({
        type: "POST",
        url: "/mysql/search.php",
        data: {search: name},
        success: function(html) {$("#display").html(html).show();}
      });
    }
  });
});

// Show messages
function showMessages() {
  var x = document.getElementById("messages");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
      x.style.display = "none";
    }
}

// Prevent form resubmission
if (window.history.replaceState) {window.history.replaceState(null, null, window.location.href);}

// Prevent Iframes
if (window.top !== window.self) {window.top.location = window.self.location;}

// File upload
var inputs = document.querySelectorAll('.inputpic');
Array.prototype.forEach.call(inputs, function(input) {
  var label	 = input.nextElementSibling, labelVal = label.innerHTML;
  input.addEventListener('change', function(e) {
    var fileName = '';
    fileName = e.target.value.split( '\\' ).pop();
    if(fileName) label.querySelector( 'span' ).innerHTML = fileName;
    else label.innerHTML = labelVal;
  });
});