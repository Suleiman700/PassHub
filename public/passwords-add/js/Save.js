
// inputs
import inputPasswordUsername from './inputs/input-password-username.js';
import inputPasswordPassword from './inputs/input-password-password.js';
import inputPasswordWebsite from './inputs/input-password-website.js';
import inputPasswordDescription from './inputs/input-password-description.js';
import inputPasswordNote from './inputs/input-password-note.js';

// buttons
import buttonSubmit from './buttons/button-submit.js';
import ButtonCancel from './buttons/button-cancel.js';

import RequestPost from '/javascript/requests/RequestPost.js';
import inputPasswordDescription from "./inputs/input-password-description";

class Save {
    constructor() {}

    async performSave() {
        console.log('here')
        // disable buttons
        buttonSubmit.enabled(false)
        ButtonCancel.enabled(false)

        const inputs = [inputPasswordUsername, inputPasswordPassword, inputPasswordWebsite, inputPasswordDescription, inputPasswordNote]

        // disable inputs
        inputs.forEach(input => input.enabled(false))

        const data = {
            passwordUsername: inputPasswordUsername.valueGet(),
            passwordPassword: inputPasswordPassword.valueGet(),
            passwordWebsite: inputPasswordWebsite.valueGet(),
            passwordDescription: inputPasswordDescription.valueGet(),
            passwordNote: inputPasswordNote.valueGet()
        }

        const response = await RequestPost.send('./php/file.php', data, 'addNewPassword')

        if (response['dataInserted']) {
            // clear fields
            inputs.forEach(input => input.valueClear())

            Swal.fire({
                icon: 'success',
                title: 'Yay!',
                html: 'Password has been saved successfully'
            })
        }
        else {
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                html:
                    response['errors'].map(error => {
                        return `<h6>${error}</h6>`;
                    }).join('')
            })
        }

        // enable buttons
        buttonSubmit.enabled(true)
        ButtonCancel.enabled(true)

        // enable inputs
        inputs.forEach(input => input.enabled(true))
    }
}

export default new Save()