function submitForm(formId, url, type, formData, successCallback = null, errorCallback = null) {
    const form = document.getElementById(formId);

    console.log('Submitting form:', formId);
    console.log('URL:', url);
    console.log('Form data:', formData);

    // Show loading state
    const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
    let originalText = '';

    if (submitBtn) {
        originalText = submitBtn.textContent;
        submitBtn.textContent = 'Submitting...';
        submitBtn.disabled = true;
    }

    // Check if formData contains files (for FormData objects)
    let dataToSend = formData;
    let contentType = true; 
    
    // If formData is a plain object, convert to URL encoded string
    if (!(formData instanceof FormData)) {
        dataToSend = $.param(formData);
        contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
    } else {
        contentType = false;
    }

    // Ajax request
    $.ajax({
        method: type,
        url: url,
        data: dataToSend,
        processData: !(formData instanceof FormData), 
        contentType: contentType,
        dataType: 'json',
        success: function(response) {
            console.log(`${formId} success:`, response);
            
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response, form);
            }
        },
        error: function(obj, status, error) {
            console.error(`${formId} error:`, error);
            console.error('Response:', obj.responseText);
            
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(obj, status, error, form);
            } else {
                const responseMsg = document.getElementById('carResponseMsg');
                if (responseMsg) {
                    responseMsg.className = 'error';
                    responseMsg.textContent = 'An error occurred. Please try again.';
                    responseMsg.style.display = 'block';
                }
            }
        },
        complete: function() {
            if (submitBtn) {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        }
    });

    return false;
}