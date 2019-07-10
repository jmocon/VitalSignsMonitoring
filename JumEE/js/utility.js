function toggleIsSuccess(element,status){
  if (status) {
    $(element).addClass("has-success");
    $(element).removeClass("has-error");
  } else {
    $(element).removeClass("has-success");
    $(element).addClass("has-error");
  }

}
