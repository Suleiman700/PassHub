import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import SecuritySettings from '../SecuritySettings.js';

function callback(_cb) {
    SecuritySettings.performSecuritySettingsSave()
}


const buttonSave = new ButtonManager('body', 'save', callback)

buttonSave.onClick()

export default buttonSave