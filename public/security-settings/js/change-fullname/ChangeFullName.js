
// inputs
import inputFullname from './inputs/input-fullname.js'
import inputPassword from './inputs/input-password.js';

// buttons
import buttonSave from './buttons/button-save.js';

// labels
import labelFullName from '../labels/label-fullname.js';
import labelSidebarFullname from '../../../../include/components/js/labels/label-sidebar-fullname.js';

// requests
import RequestPost from '/javascript/requests/RequestPost.js';

class ChangeFullName {

    constructor() {}

    async performFullNameChange() {
        let isValid = true
        const errors = []

        // disable elements
        const elements = [inputFullname, inputPassword, buttonSave]
        elements.map(element => element.enabled(false))

        // get data
        const fullName = inputFullname.valueGet()
        const password = inputPassword.valueGet()

        // check fullname
        if (!fullName) {
            inputFullname.markError(true)
            // update flag
            isValid = false
            // store error
            errors.push('Name cannot be empty')
        } else {
            inputFullname.markError(false)
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
                fullName,
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
            const response = await RequestPost.send('./php/file.php', data, 'performFullNameChange')

            if (response['dataUpdated']) {
                // update page fullname label
                labelFullName.setText(fullName)

                // update sidebar fullname label
                labelSidebarFullname.setText(fullName)

                Swal.fire({
                    icon: 'success',
                    title: 'Yay!',
                    html: 'Fullname has been changed successfully'
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

        // clear password
        inputPassword.valueClear()

    }
}

export default new ChangeFullName()