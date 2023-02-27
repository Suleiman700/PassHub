import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import ChangePassword from '../ChangePassword.js';

function callback(_cb) {
    ChangePassword.performPasswordChange()
}


const buttonLogin = new ButtonManager('section-change-password', 'save', callback)

buttonLogin.onClick()

export default buttonLogin