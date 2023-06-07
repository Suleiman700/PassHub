import ButtonManager from '../../../../javascript/managers/button-manager/ButtonManager.js';

import Modal_DeleteHistory from '../modals/Modal_DeleteHistory.js';

function callback(_cb) {
    Modal_DeleteHistory.shown(true)
}

const buttonDeleteAllHistory = new ButtonManager('header', 'delete-all-history', callback)

buttonDeleteAllHistory.onClick()

export default buttonDeleteAllHistory