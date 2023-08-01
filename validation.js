
function checkuser() 
{
    var pattern = /^([a-zA-Z]+\s)*[a-zA-Z]+$/;
    var user = $('#name').val();
    var validuser = pattern.test(user);
    if (user == "") {
        $('#username_err').html('required field');
        return false;
    }
    else if ($('#name').val().length < 4) {
        $('#username_err').html('username length is too short');
        return false;
    } else if (!validuser) {
        $('#username_err').html('username should be a-z ,A-Z only');
        return false;
    } else {
        $('#username_err').html('');
        return true;
    }
}

function checkemail() 
{
    var pattern1 = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var email = $('#email').val();
    var validemail = pattern1.test(email);
    if (email == "") {
        $('#email_err').html('required field');
        return false;
    } else if (!validemail) {
        $('#email_err').html('invalid email');
        return false;
    } else {
        $('#email_err').html('');
        return true;
    }
}

function checkpass() 
{
    console.log("sass");
    var pattern2 = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    var pass = $('#password').val();
    var validpass = pattern2.test(pass);

    if (pass == "") {
        $('#password_err').html('password can not be empty');
        return false;
    } else if (!validpass) {
        $('#password_err').html('Minimum 5 and upto 15 characters, at least one uppercase letter, one lowercase letter, one number and one special character:');
        return false;

    } else {
        $('#password_err').html("");
        return true;
    }
}
