
// buttons
import buttonConfirmDelete from './buttons/button-confirm-delete.js';

// requests
import RequestPost from '/javascript/requests/RequestPost.js';

class Modal_DeleteCategory {
    constructor() {
        this.modalId = 'modal_category_delete'
    }

    /**
     * show or hide modal
     * @param _option
     */
    shown(_option) {
        if (_option) $(`#${this.modalId}`).modal('show')
        else $(`#${this.modalId}`).modal('hide')
    }

    async performCategoryDelete() {
        // get category id
        const categoryId = new URL(location.href).searchParams.get('id')

        const response = await RequestPost.send('./php/file.php', data, 'performCategoryDelete')
    }
}

export default new Modal_DeleteCategory()