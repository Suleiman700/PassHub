// inputs
import inputPasswordUsername from './inputs/input-password-username.js';
import inputPasswordPassword from './inputs/input-password-password.js';
import inputPasswordWebsite from './inputs/input-password-website.js';
import inputPasswordDescription from './inputs/input-password-description.js';
import inputPasswordNote from './inputs/input-password-note.js';

// selects
import selectCategory from './selects/select-category.js'

// buttons
import buttonSubmit from './buttons/button-submit.js';
import buttonCancel from './buttons/button-cancel.js';

// data
import Data_Categories from './data/Data_Categories.js';

// get categories in put them into select
await Data_Categories.fetchCategories()
const categories = Data_Categories.dataGet()
if (categories.length) {
    selectCategory.put_options(categories, 'id', 'name')
}
else {
    // disable all fields and buttons
    const elements = [inputPasswordUsername, inputPasswordPassword, inputPasswordWebsite, inputPasswordDescription, inputPasswordNote, buttonSubmit, buttonCancel]
    elements.forEach(element => element.enabled(false))

    Swal.fire({
        icon: 'error',
        title: 'Ops!',
        html: `
            <lable>It looks like you don't have any categories yet.</lable>
            <lable>You'll have to create category first.</lable>
        `,
        allowOutsideClick: false,
        confirmButtonText: 'Create Category'
    }).then(function() {
        window.location = '../categories-add/index.php';
    });
}

