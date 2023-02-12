import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import Modal_DeletePassword from '../Modal_DeletePassword.js';

function callback(_cb) {
    Modal_DeletePassword.performPasswordDelete()
}

const buttonConfirmDelete = new ButtonManager('modal_password_delete', 'confirm-delete', callback)

buttonConfirmDelete.onClick()

export default buttonConfirmDelete