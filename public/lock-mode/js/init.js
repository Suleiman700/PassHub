import RequestPost from '/javascript/requests/RequestPost.js';

// encryption
import EncryptionService from '/javascript/security/EncryptionService.js';

const infoLabel = document.querySelector('#info-label')

const input1 = document.querySelector('#input1');
const input2 = document.querySelector('#input2');
const input3 = document.querySelector('#input3');
const input4 = document.querySelector('#input4');
const inputs = [input1, input2, input3, input4]

function validateAndMove(currentInput) {
    if (!isNaN(currentInput.value)) {
        if (currentInput.value.length === 1) {
            if (currentInput.nextElementSibling !== null) {
                currentInput.nextElementSibling.focus();
            }
        }
        else if (currentInput.value.length === 0) {
            currentInput.previousElementSibling.focus();
        }
    }
    else {
        currentInput.value = "";
    }

    checkAllInputs()
}

// document.querySelectorAll('.input-square')

inputs.forEach(input => {
    input.addEventListener('input', (event) => {
        validateAndMove(event.target)
    })
})

async function checkAllInputs() {
    if (input1.value !== "" && input2.value !== "" && input3.value !== "" && input4.value !== "") {
        // disable all inputs
        inputs.forEach(input => input.setAttribute('disabled', 'disabled'))

        // set info label text
        infoLabel.innerHTML = 'Checking Pin Code, Please Wait... <i class="fa fa-spinner"></i>'

        // send request
        const pinCode = inputs.map(input => input.value).join('')
        const data = {
            pinCode: pinCode
        }
        const response = await RequestPost.send('./php/file.php', data, 'checkPinCode')

        // clear info label
        infoLabel.innerHTML = ''

        // clear all inputs
        inputs.forEach(input => input.value = '')

        // enable all inputs
        inputs.forEach(input => input.removeAttribute('disabled'))

        if (response['isValid']) {
            Swal.fire({
                icon: 'success',
                title: 'Great!',
                html: `Account unlocked successfully`,
                allowOutsideClick: false,
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../dashboard/index.php';
            });
        }
        else {
            // show error
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                html:
                    response['errors'].map(error => {
                        return `
                            <div>
                                <h6>${error['error']}</h6>
                                <h6>Error Code: ${error['errorCode']}</h6>
                            </div>
                        `;
                    }).join('')
            })
        }
    }
}

// check message from url parameter
const messageParam = location.search.split('message=')[1]
if (messageParam.length) {
    console.log(messageParam)
    const encryptionService = new EncryptionService()
    const decryptedMessage = await encryptionService.decryptMessage(messageParam)
    document.querySelector('#message').innerHTML = decryptedMessage
}