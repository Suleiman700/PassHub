
// inputs
import inputOriginalPassword from './inputs/input-original-password.js'
import inputNewPassword from './inputs/input-new-password.js';
import inputConfirmNewPassword from './inputs/input-confirm-new-password.js';

// buttons
import buttonSave from './buttons/button-save.js';

// requests
import RequestPost from '../../../../javascript/requests/RequestPost.js';

class ChangePassword {

    constructor() {}

    async performPasswordChange() {
        let isValid = true
        const errors = []

        // disable elements
        const elements = [inputOriginalPassword, inputNewPassword, inputConfirmNewPassword, buttonSave]
        elements.map(element => element.enabled(false))

        // get data
        const originalPassword = inputOriginalPassword.valueGet()
        const newPassword = inputNewPassword.valueGet()
        const confirmNewPassword = inputConfirmNewPassword.valueGet()

        // check original password
        if (!originalPassword) {
            inputOriginalPassword.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Original password cannot be empty')
        } else {
            inputOriginalPassword.markError(false)
        }

        // check new password
        if (!newPassword) {
            inputNewPassword.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('New password cannot be empty')
        } else {
            inputNewPassword.markError(false)
        }

        // check confirm new password
        if (!confirmNewPassword) {
            inputConfirmNewPassword.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Password confirmation cannot be empty')
        } else {
            inputConfirmNewPassword.markError(false)
        }

        // check if new password matches password confirmation
        if (newPassword != confirmNewPassword) {
            // update flag
            isValid = false
            // store error
            errors.push('Password confirmation does not match!')
        }

        // check if original password matches the new password
        if (originalPassword == newPassword) {
            // update flag
            isValid = false
            // store error
            errors.push('The original password and the new password cannot be the same. Please enter a different new password')
        }

        if (isValid) {
            // store data for request
            const data = {
                originalPassword,
                newPassword
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
            const response = await RequestPost.send('./php/file.php', data, 'performPasswordChange')

            if (response['dataUpdated']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Yay!',
                    html: 'Password has been changed successfully'
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

        // clear passwords
        inputOriginalPassword.valueClear()
        inputNewPassword.valueClear()
        inputConfirmNewPassword.valueClear()

    }
}

export default new ChangePassword()