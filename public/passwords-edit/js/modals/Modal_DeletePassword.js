
// buttons
import buttonConfirmDelete from './buttons/button-confirm-delete.js';

// requests
import RequestPost from '../../../../javascript/requests/RequestPost.js';


class Modal_DeletePassword {
    constructor() {
        this.modalId = 'modal_password_delete'
    }

    /**
     * show or hide modal
     * @param _option
     */
    shown(_option) {
        if (_option) $(`#${this.modalId}`).modal('show')
        else $(`#${this.modalId}`).modal('hide')
    }

    async performPasswordDelete() {
        // get password id
        const passwordId = new URL(location.href).searchParams.get('id')

        const response = await RequestPost.send('./php/file.php', {passwordId: passwordId}, 'performPasswordDelete')

        if (response['dataDeleted']) {
            Swal.fire({
                icon: 'success',
                title: 'Great!',
                html: `Password has been deleted successfully`,
                allowOutsideClick: false,
                confirmButtonText: 'Ok'
            }).then(function() {
                window.location = '../passwords-list/index.php';
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
}

export default new Modal_DeletePassword()