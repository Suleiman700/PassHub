import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import Login from '../Login.js'

function callback(_cb) {
    Login.performLogin()
}

const options = {
    hasSpinner: true,
    spinnerDir: 'LTR',
}

const buttonLogin = new ButtonManager('login-form', 'login', callback, options)

buttonLogin.onClick()

export default buttonLogin