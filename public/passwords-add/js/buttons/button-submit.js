import ButtonManager from '../../../../javascript/managers/button-manager/ButtonManager.js';

import Save from '../Save.js';

function callback(_cb) {
    Save.performSave()
}

const buttonSubmit = new ButtonManager('form', 'submit', callback)

buttonSubmit.onClick()

export default buttonSubmit