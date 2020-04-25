$(document).ready(function() {
    $('.phoneError').hide();
    $('.emailError').hide();
    $('.inputError').hide();

    /**
     * Handles everything related to the submitted form
     * 
     * All datas are stored into formData object. If everything's fine
     * the data is sent to the server
     */
    $("#form_submit").click(function(event) {
        event.preventDefault();
        let formData = {
            lastname: $("#exampleInputLastname").val(),
            firstname: $("#exampleInputFirstName").val(),
            birthdate: $("#exampleInputBirthDate").val(),
            picture: $("#exampleInputPicture").val(),
            phone: $("#exampleInputPhone").val(),
            address: $("#exampleInputAddress").val(),
            email: $("#exampleInputEmail").val(),
        };

        let process = [];

        if(formData.lastname === "" || formData.firstName === "" || formData.birthdate === "") {
            $('.inputError').show();
            return false;
        }
        if(isEmailValid(formData.email) === false || formData.email === "") {
            $('.emailError').show();
            process = "error detected";
        }
        else {
            $('.emailError').hide();
        }
        if(formData.phone !== "") {
            if(isPhoneValid(formData.phone) === false) {
                $('.phoneError').show();
                process = "error detected";
            }
            else {
                $('.phoneError').hide();   
            }
        }  
        //console.log(process.length);

        if(process.length < 1) {
            //console.log("pouet");
            $.ajax({
                type:'post',
                url: 'http://localhost:8000/form.php',
                data: formData,
                dataType:"html",
                success : function(data) {
                    console.log(data);
                    if(data === "success") {
                        $("#form_submit").after("<p>Data sent to the server!</p>")
                    }
                },
                error : function(result, status, error) {
                    console.log(error);
                }
            });
        }
    });
    
    /**
     * Function that checks if the email is valid
     * 
     * @param {string} email - email provided by the user
     * 
     * @return {bool} - false if invalid, true otherwise
     */
    function isEmailValid(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
            return false;
        } 
        else {
            return true;
        }   
    };

    /**
     * Function that checks if the phone number is valid
     * 
     * @param {string} phone - phone number provided by the user
     * 
     * @return {bool} - false if invalid, true otherwise
     */
    function isPhoneValid(phone) {
        var regex = /^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/;
        if(!regex.test(phone)) {
            return false;
        } 
        else {
            return true;
        }
        
    }
});