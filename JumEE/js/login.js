function login(){

  var url = "Ajax/User.php?c=login";
  var param = "";

  var username = $('#txtUsername').val();
  var password = $('#txtPassword').val();

  if (username && password) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText){
          let result = JSON.parse(this.responseText);

          if (result.success) {
            window.location.replace("index.php");
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
    param += "&Password=" + password;
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
      Please Complete All Required Fields.
    </div>
    `;
    $('#notification').html(notif);
  }
}

function register(){
  $('#reg_loading').removeClass('d-none');
  $('#reg_notification').html('');
  var url = "Ajax/User.php?c=add";
  var param = "";

  var username    = $('#txt_regUsername').val();
  var password    = $('#txt_regPassword').val();
  var firstname   = $('#txt_regFirstName').val();
  var middlename  = $('#txt_regMiddleName').val();
  var lastname    = $('#txt_regLastName').val();
  var age         = $('#txt_regAge').val();
  var gender      = $('#sel_regGender').val();
  var address     = $('#txt_regAddress').val();

  var missing = false;
  if (!username) {
    missing = true;
  }
  if (!password) {
    missing = true;
  }
  if (!firstname) {
    missing = true;
  }
  if (!middlename) {
    missing = true;
  }
  if (!lastname) {
    missing = true;
  }
  if (!age) {
    missing = true;
  }
  if (!gender) {
    missing = true;
  }
  if (!address) {
    missing = true;
  }

  if (!missing) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText){
          let result = JSON.parse(this.responseText);
          $('#reg_loading').addClass('d-none');
          if (result.success) {
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
            $('#reg_notification').html(notif);
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
            $('#reg_notification').html(notif);
          }
        }
      }
    };
    param += "Username=" + username;
    param += "&Password=" + password;
    param += "&FirstName=" + firstname;
    param += "&MiddleName=" + middlename;
    param += "&LastName=" + lastname;
    param += "&Age=" + age;
    param += "&Gender=" + gender;
    param += "&Address=" + address;
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send(param);
  } else {
    $('#reg_loading').addClass('d-none');
    let notif = `
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        <span class="sr-only">Close</span>
      </button>
      Please Complete All Fields.
    </div>
    `;
    $('#reg_notification').html(notif);
  }
}
