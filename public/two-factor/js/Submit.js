
import RequestPost from '/javascript/requests/RequestPost.js';

// buttons
import buttonContinue from './buttons/button-register.js';

// inputs
import inputTwoFactorCode from './inputs/input-two-factor-code.js';

class Submit{
    constructor() {}

    async submit2FACode() {
        // disable elements
        buttonContinue.enabled(false)
        inputTwoFactorCode.enabled(false)

        // set info label text
        const infoLabel = document.querySelector('#message')
        infoLabel.innerHTML = 'Checking 2FA Code, Please Wait... <i class="fa fa-spinner"></i>'

        // send request
        const twoFactorCode = inputTwoFactorCode.valueGet()

        const response = await RequestPost.send('./php/file.php', {twoFactorCode}, 'checkTwoFactorCode')

        // clear info label
        infoLabel.innerHTML = ''

        // clear input
        inputTwoFactorCode.valueClear()

        // enable elements
        buttonContinue.enabled(true)
        inputTwoFactorCode.enabled(true)

        if (response['isValid']) {
            Swal.fire({
                icon: 'success',
                title: 'Great!',
                html: `Correct Two Factor Code`,
                allowOutsideClick: false,
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../categories-list/index.php';
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

export default new Submit()