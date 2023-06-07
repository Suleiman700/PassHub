
// inputs
import inputNewPinCode from './inputs/input-new-pin-code.js';
import inputPassword from './inputs/input-password.js'

// buttons
import buttonSave from './buttons/button-save.js';

// requests
import RequestPost from '../../../../javascript/requests/RequestPost.js';

// validators
import PinCodeValidator from '../../../../javascript/validators/PinCodeValidator.js';

class ChangePinCode {

    constructor() {}

    async performPinCodeChange() {
        let isValid = true
        const errors = []

        // disable elements
        const elements = [inputNewPinCode, inputPassword, buttonSave]
        elements.map(element => element.enabled(false))

        // get data
        const newPinCode = inputNewPinCode.valueGet()
        const password = inputPassword.valueGet()

        // check new Pin Code
        if (!newPinCode) {
            inputNewPinCode.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('New Pin Code cannot be empty')
        } else {
            inputNewPinCode.markError(false)
        }

        // validate new Pin Code
        const isValidNewPinCode = PinCodeValidator.validate(newPinCode)
        if (!isValidNewPinCode) {
            inputNewPinCode.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Pin Code should be 4 digits long')
        } else {
            inputNewPinCode.markError(false)
        }

        // check password
        if (!password) {
            inputPassword.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Password cannot be empty')
        } else {
            inputPassword.markError(false)
        }

        if (isValid) {
            // store data for request
            const data = {
                newPinCode,
                password
            }

            // show loading
            Swal.fire({
                icon: 'info',
                title: 'Please Wait',
                html: '<i class="fa fa-spinner fa-spin"></i> Updating data...',
                showConfirmButton: false,
                allowOutsideClick: false
            });

            // send request
            const response = await RequestPost.send('./php/file.php', data, 'performPinCodeChange')

            if (response['dataUpdated']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Yay!',
                    html: 'Pin Code has been changed successfully'
                })
            }
            else {
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
        else {
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                html:
                    errors.map(error => {
                        return `
                            <div>
                                <h6>${error}</h6>
                            </div>
                        `;
                    }).join('')
            })
        }

        // enable elements
        elements.map(element => element.enabled(true))

        // clear elements
        inputNewPinCode.valueClear()
        inputPassword.valueClear()

    }
}

export default new ChangePinCode()