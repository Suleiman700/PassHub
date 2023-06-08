
// inputs
import inputFullname from './inputs/input-fullname.js';
import inputEmailAddress from './inputs/input-email-address.js';
import inputPassword from './inputs/input-password.js';
import inputPinCode from './inputs/input-pin-code.js';

// buttons
import buttonRegister from './buttons/button-register.js';

// alerts
import alert from './alerts/alert.js';

// validators
import EmailValidator from '../../../javascript/validators/EmailValidator.js';
import PinCodeValidator from '../../../javascript/validators/PinCodeValidator.js';

// requests
import RequestPost from '../../../javascript/requests/RequestPost.js';

class Register {
    constructor() {}

    /**
     * perform register process
     */
    async performRegister() {
        let isValid = true
        const errors = []

        // check username
        const fullname = inputFullname.valueGet()
        if (!fullname || !fullname.length) {
            inputFullname.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Full name is invalid')
        } else {
            inputFullname.markError(false)
        }

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
            errors.push('Pin code must be 4 digits long number')
        } else {
            inputPinCode.markError(false)
        }

        if (isValid) {
            // disable login button
            buttonRegister.enabled(false)
            buttonRegister.showSpinner(true)

            alert.shown(false)

            const data = {
                fullname,
                emailAddress,
                password,
                pinCode
            }

            const response = await RequestPost.send('./php/file.php', data, 'performRegister')

            // enable login button
            buttonRegister.enabled(true)
            buttonRegister.showSpinner(false)

            // successful request
            if (response['state']) {
                window.location.replace('../login/index.php');

            }
            // unsuccessful request
            else if (!response['state']) {
                // show alert
                alert.colorSet('danger')
                alert.shown(true)
                alert.valueSet(response['errors'])
            }
        }
        else {
            // show alert
            alert.colorSet('danger')
            alert.shown(true)
            alert.valueSet(errors)
            return;
        }
    }
}

export default new Register()