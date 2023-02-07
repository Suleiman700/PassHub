// inputs
import inputEmailAddress from './inputs/input-email-address.js';
import inputPassword from './inputs/input-password.js';
import inputPinCode from './inputs/input-pin-code.js';

// buttons
import buttonLogin from './buttons/button-login.js';

// alerts
import alert from './alerts/alert.js';

// validators
import EmailValidator from '/javascript/validators/EmailValidator.js';
import PinCodeValidator from '/javascript/validators/PinCodeValidator.js';

// requests
import RequestPost from '/javascript/requests/RequestPost.js';



class Login {
    #emailAddress = undefined
    #password = undefined
    #pinCode = undefined

    constructor() {
    }

    /**
     * perform login process
     */
    async performLogin() {
        let isValid = true
        const errors = []

        // check email address
        const emailAddress = inputEmailAddress.valueGet()
        const isValidEmailAddress = EmailValidator.validate(emailAddress)
        if (!isValidEmailAddress) {
            inputEmailAddress.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Email address is invalid')
        } else {
            inputEmailAddress.markError(false)
        }

        // check password
        const password = inputPassword.valueGet()
        if (!password || !password.length) {
            inputPassword.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Password is invalid')
        } else {
            inputPassword.markError(false)
        }

        // check pin code
        const pinCode = inputPinCode.valueGet()
        const isValidPinCode = PinCodeValidator.validate(pinCode)
        if (!isValidPinCode) {
            inputPinCode.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Pin code is invalid')
        } else {
            inputPinCode.markError(false)
        }

        if (isValid) {
            // disable login button
            buttonLogin.enabled(false)
            buttonLogin.showSpinner(true)

            alert.shown(false)

            const data = {
                emailAddress,
                password,
                pinCode
            }


            const response = await RequestPost.send('./php/file.php', data, 'performLogin')

            // enable login button
            buttonLogin.enabled(true)
            buttonLogin.showSpinner(false)

            // successful request
            if (response['state']) {
                window.location.replace('../dashboard/index.php');

            }
            // unsuccessful request
            else if (!response['state']) {
                // show alert
                alert.colorSet('danger')
                alert.shown(true)
                alert.valueSet(response['errors'])
            }
        } else {
            // show alert
            alert.colorSet('danger')
            alert.shown(true)
            alert.valueSet(errors)
            return;
        }
    }

}

export default new Login()