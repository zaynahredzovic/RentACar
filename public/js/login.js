const loginForm = document.getElementById('loginForm');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const responseMsg = document.getElementById('responseMsg');
const loginBtn = document.getElementById('loginBtn');

loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const originalText = loginBtn.textContent;

    //login state
    loginBtn.textContent = "Logging in...";
    loginBtn.disabled = true;

    //clear msgs 
    responseMsg.className = '';
    responseMsg.textContent = '';

    //Get form data
    const formData = {
        email: emailInput.value,
        password: passwordInput.value,
    }

    //basic validation
    if(!formData.email || !formData.password){
        responseMsg.className = 'error';
        responseMsg.textContent = 'Please fill in all fields'
        loginBtn.textContent = originalText;
        loginBtn.disabled = false;
        return;
    }

    //ajax request
    $.ajax({
        type: 'POST',
        url: '/rentacar/api/login',
        data: formData,
        dataType: 'json',
        success: (response) => {
            if(response.status === 'success'){
                responseMsg.className = 'success';
                responseMsg.textContent = response.message;
                
                //clear form
                loginForm.reset();

                //redirect
                setTimeout(() => {
                    window.location.href = '/rentacar/dashboard';
                }, 1000);
            }else{
                responseMsg.className = 'error';
                responseMsg.textContent = response.message;
            }
        },
        error: (obj, status, error) => {
            console.log('Login error: ', error);
            console.log('Response Tect: ', obj.responseText);
            console.log('Status', obj.status);
            responseMsg.className = 'error';
            responseMsg.textContent = 'An error occured. Please try again.';
        }, 
        complete: () => {
            loginBtn.textContent = originalText;
            loginBtn.disabled = false;
        }
    });
})