
// buttons
import buttonSave from './buttons/button-save.js';

// requests
import RequestPost from '/javascript/requests/RequestPost.js';

class SecuritySettings {
    constructor() {}

    async performSecuritySettingsSave() {

        // disable button
        buttonSave.enabled(false)

        const enable2FA = document.querySelector('#body #checkbox-enable-2fa').checked
        const enableLoginAlerts = document.querySelector('#body #checkbox-enable-login-alerts').checked
        const enablePasswordChangeAlerts = document.querySelector('#body #checkbox-enable-password-change-alerts').checked
        const enablePinCodeChangeAlerts = document.querySelector('#body #checkbox-enable-pin-code-change-alerts').checked

        // show loading
        Swal.fire({
            icon: 'info',
            title: 'Please Wait',
            html: '<i class="fa fa-spinner fa-spin"></i> Updating data...',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        const data = {
            enable2FA,
            enableLoginAlerts,
            enablePasswordChangeAlerts,
            enablePinCodeChangeAlerts
        }

        // send request
        const response = await RequestPost.send('./php/file.php', data, 'performSecuritySettingsSave')

        if (response['dataUpdated']) {
            Swal.fire({
                icon: 'success',
                title: 'Yay!',
                html: 'Data has been updated successfully'
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

        // enable button
        buttonSave.enabled(true)
    }
}

export default new SecuritySettings()