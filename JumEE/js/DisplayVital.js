function clearByUsername(username){
  var url = "Ajax/Vital.php?c=delete";
  var param = "";


  if (username) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText){
          let result = JSON.parse(this.responseText);

          if (result.success) {
            window.location.replace("DisplayUser.php");
            let notif = `
            <div class="alert alert-success alert-dismissible text-dark" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
            </button>
            `+result.title+`
            <p class="m-0">`+result.message+`</p>
            </div>
            `;
            $('#notification').html(notif);
          } else {
            let notif = `
            <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
            </button>
            `+result.title+`
            <p>`+result.message+`</p>
            </div>
            `;
            $('#notification').html(notif);
          }
        }


      }
    };
    param += "Username=" + username;
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send(param);
  } else {
    let notif = `
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        <span class="sr-only">Close</span>
      </button>
      Something is wrong. Please refresh the page.
    </div>
    `;
    $('#notification').html(notif);
  }
}
