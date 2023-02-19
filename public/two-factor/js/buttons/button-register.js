import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import Submit from '../Submit.js'

function callback(_cb) {
    Submit.submit2FACode()
}

const buttonContinue = new ButtonManager('main', 'continue', callback)

buttonContinue.onClick()

export default buttonContinue