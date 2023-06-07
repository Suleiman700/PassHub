import ButtonManager from '../../../../../javascript/managers/button-manager/ButtonManager.js';

import ChangeFullName from '../ChangeFullName.js'

function callback(_cb) {
    ChangeFullName.performFullNameChange()
}


const buttonLogin = new ButtonManager('section-fullname', 'save', callback)

buttonLogin.onClick()

export default buttonLogin