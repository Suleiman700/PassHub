import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import changePinCode from '../ChangePinCode.js';

function callback(_cb) {
    changePinCode.performPinCodeChange()
}


const buttonLogin = new ButtonManager('section-change-pin-code', 'save', callback)

buttonLogin.onClick()

export default buttonLogin