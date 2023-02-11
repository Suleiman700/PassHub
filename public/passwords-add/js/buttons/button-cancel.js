import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import Save from '../Save.js';

function callback(_cb) {
    window.location.replace('../passwords-list/index.php');
}

const buttonCancel = new ButtonManager('form', 'cancel', callback)

buttonCancel.onClick()

export default buttonCancel