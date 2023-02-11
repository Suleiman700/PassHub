import ButtonManager from '/javascript/managers/button-manager/ButtonManager.js';

import Modal_DeleteCategory from '../Modal_DeleteCategory.js';

function callback(_cb) {
    Modal_DeleteCategory.performCategoryDelete()
}

const buttonConfirmDelete = new ButtonManager('modal_category_delete', 'confirm-delete', callback)

buttonConfirmDelete.onClick()

export default buttonConfirmDelete