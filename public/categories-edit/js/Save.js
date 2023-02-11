
// inputs
import inputCategoryName from './inputs/input-category-name.js';
import inputCategoryDescription from './inputs/input-category-description.js';
import inputCategoryColor from './inputs/input-category-color.js';

// buttons
import buttonSubmit from './buttons/button-submit.js';
import ButtonCancel from './buttons/button-cancel.js';

import RequestPost from '/javascript/requests/RequestPost.js';

class Save {
    constructor() {}

    async performSave() {
        // disable buttons
        buttonSubmit.showSpinner(true)
        buttonSubmit.enabled(false)
        ButtonCancel.enabled(false)

        const inputs = [inputCategoryName, inputCategoryDescription, inputCategoryColor]

        // disable inputs
        inputs.forEach(input => input.enabled(false))

        const data = {
            categoryId: new URL(location.href).searchParams.get('id'), // get category id from url
            categoryName: inputCategoryName.valueGet(),
            categoryDescription: inputCategoryDescription.valueGet(),
            categoryColor: inputCategoryColor.valueGet(),
        }
        const response = await RequestPost.send('./php/file.php', data, 'saveEditedCategory')

        if (response['dateUpdated']) {
            Swal.fire({
                icon: 'success',
                title: 'Yay!',
                html: 'Category has been updated successfully'
            })
        }
        else {
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                // html: 'An error occurred',
                html:
                    response['errors'].map(error => {
                        return `<h6>${error}</h6>`;
                    }).join('')
            })
        }

        // enable buttons
        buttonSubmit.showSpinner(false)
        buttonSubmit.enabled(true)
        ButtonCancel.enabled(true)

        // enable inputs
        inputs.forEach(input => input.enabled(true))
    }
}

export default new Save()