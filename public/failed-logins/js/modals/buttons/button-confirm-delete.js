import ButtonManager from '../../../../../javascript/managers/button-manager/ButtonManager.js';

import Modal_DeleteHistory from '../Modal_DeleteHistory.js';

function callback(_cb) {
    Modal_DeleteHistory.performHistoryDelete()
}

const buttonConfirmDelete = new ButtonManager('modal_delete_history', 'confirm-delete', callback)

buttonConfirmDelete.onClick()

export default buttonConfirmDelete