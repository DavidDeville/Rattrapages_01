$(document).ready(function() {
    $('.phoneError').hide();
    $('.emailError').hide();

    $("#form_submit").click(function(event) {
        event.preventDefault();
        let formData = {
            name: $("#exampleInputName").val(),
            firstName: $("#exampleInputFirstName").val(),
            birthdate: $("#exampleInputBirthDate").val(),
            picture: $("#exampleInputPicture").val(),
            phone: $("#exampleInputPhone").val(),
            address: $("#exampleInputAddress").val(),
            email: $("#exampleInputEmail").val(),
        };
        if(isEmailValid(formData.email) === false) {
            $('.emailError').show();
            return false;
        } else {
            $('.emailError').hide();
        }
        if(isPhoneValid(formData.phone) === false) {
            $('.phoneError').show();
            return false;
        } else {
            $('.phoneError').hide();
        }
        console.log(formData);
    });

    function isEmailValid(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
            return false;
        } 
        else {
            return true;
        }
        
    };

    function isPhoneValid(phone) {
        var regex = /^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/;
        if(!regex.test(phone)) {
            return false;
        } else {
            return true;
        }
        
    }
});