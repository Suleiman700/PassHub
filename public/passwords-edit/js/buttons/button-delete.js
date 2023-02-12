import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import Modal_DeletePassword from '../modals/Modal_DeletePassword.js';

function callback(_cb) {
    Modal_DeletePassword.shown(true)
}

const buttonDelete = new ButtonManager('form', 'delete', callback)

buttonDelete.onClick()

export default buttonDelete