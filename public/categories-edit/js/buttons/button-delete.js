import ButtonManager from '../../../../javascript/managers/button-manager/ButtonManager.js';

import Modal_DeleteCategory from '../modals/Modal_DeleteCategory.js';

function callback(_cb) {
    Modal_DeleteCategory.shown(true)
}

const buttonDelete = new ButtonManager('form', 'delete', callback)

buttonDelete.onClick()

export default buttonDelete