
    $(function() {
        // this will get the full URL at the address bar
        var url = window.location.href;

        // passes on every "a" tag
        $(".topmenu a").each(function() {
            // checks if its the same on the address bar
            if (url == (this.href)) {
                $(this).closest("li").addClass("active");
                //for making parent of submenu active
               $(this).closest("li").parent().parent().addClass("active");
            }
        });
    });        

function validate(form) {
  var re = /^[a-z,A-Z]+$/i;

  if (!re.test(form.dob.value)) {
    alert('Please enter only letters from a to z');
    return false;
  }
}