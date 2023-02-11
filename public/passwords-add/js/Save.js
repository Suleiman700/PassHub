
// selects
import selectCategory from './selects/select-category.js';

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

class Save {
    constructor() {}

    async performSave() {
        // disable elements
        const elements = [selectCategory, inputPasswordUsername, inputPasswordPassword, inputPasswordWebsite, inputPasswordDescription, inputPasswordNote, buttonSubmit, ButtonCancel]
        elements.forEach(element => element.enabled(false))

        const data = {
            categoryId: selectCategory.get_selected_value(),
            username: inputPasswordUsername.valueGet(),
            password: inputPasswordPassword.valueGet(),
            website: inputPasswordWebsite.valueGet(),
            description: inputPasswordDescription.valueGet(),
            note: inputPasswordNote.valueGet()
        }

        const response = await RequestPost.send('./php/file.php', data, 'addNewPassword')

        if (response['dataInserted']) {
            // clear inputs
            const inputs = [inputPasswordUsername, inputPasswordPassword, inputPasswordWebsite, inputPasswordDescription, inputPasswordNote]
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
                        return `
                            <div>
                                <h6>${error['error']}</h6>
                                <h6>Error Code: ${error['errorCode']}</h6>
                            </div>
                        `;
                    }).join('')
            })
        }

        // enable elements
        elements.forEach(element => element.enabled(true))
    }
}

export default new Save()