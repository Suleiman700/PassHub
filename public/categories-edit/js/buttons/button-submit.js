import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import Save from '../Save.js';

function callback(_cb) {
    Save.performSave()
}

const options = {
    hasSpinner: true,
    spinnerDir: 'LTR',
}

const buttonSubmit = new ButtonManager('form', 'submit', callback, options)

buttonSubmit.onClick()

export default buttonSubmit