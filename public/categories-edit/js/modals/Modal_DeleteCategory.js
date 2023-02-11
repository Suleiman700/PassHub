
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
        if (_option) {
            $(`#${this.modalId}`).modal('show')

            // show passwords count text
            const passwordsCount = document.querySelector('#category-passwords-count').value
            this.#showPasswordsCount(passwordsCount)
        }
        else $(`#${this.modalId}`).modal('hide')
    }

    async performCategoryDelete() {
        // get category id
        const categoryId = new URL(location.href).searchParams.get('id')

        const response = await RequestPost.send('./php/file.php', {categoryId: categoryId}, 'performCategoryDelete')

        if (response['dataDeleted']) {
            Swal.fire({
                icon: 'success',
                title: 'Great!',
                html: `Category has been deleted successfully`,
                allowOutsideClick: false,
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../categories-list/index.php';
            });
        }
        else {
            // show errors
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                html:
                    response['errors'].map(error => {
                        return `
                            <div>
                                <h6>${error['error']}</h6>
                                <h6>Error Code: ${error['errorCode']}</h6>
                            </div>
                        `;
                    }).join('')
            })
        }

        console.log(response)
    }

    /**
     * show passwords count in modal body
     * @param _passwordsCount {number}
     */
    #showPasswordsCount(_passwordsCount) {
        const text = document.querySelector(`#${this.modalId} #passwords-count`)

        // set text
        text.innerText = _passwordsCount

        // set text color
        if (_passwordsCount > 0) text.classList.add('text-danger')
        else text.classList.add('text-success')
    }
}

export default new Modal_DeleteCategory()