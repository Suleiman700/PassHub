import ButtonManager from '../../../../javascript/managers/button-manager/ButtonManager.js';

import Register from '../Register.js'

function callback(_cb) {
    console.log('clicked')
    Register.performRegister()
}

const options = {
    hasSpinner: true,
    spinnerDir: 'LTR',
}

const buttonRegister = new ButtonManager('register-form', 'register', callback, options)

buttonRegister.onClick()

export default buttonRegister