
// buttons
import buttonConfirmDelete from './buttons/button-confirm-delete.js';
import buttonDeleteAllHistory from '../buttons/button-delete-all-history.js';

// tables
import Tbl_FailedLogins from '../tables/Tbl_FailedLogins.js';

// requests
import RequestPost from '../../../../javascript/requests/RequestPost.js';

class Modal_DeleteHistory {

    targetHistoryId = undefined // pass history id to delete a specific history, if not passed it will delete all history

    constructor() {
        this.modalId = 'modal_delete_history'
    }

    /**
     * show or hide modal
     * @param _option {boolean}
     * @return {void}
     */
    shown(_option) {
        const option = (_option==true)?'show':'hide'
        $(`#${this.modalId}`).modal(option)

        if (_option == true) {
            // change title
            if (this.targetHistoryId !== undefined) {
                document.querySelector(`#${this.modalId} #title`).innerText = 'Do you want to delete this history ?'
            }
            else {
                document.querySelector(`#${this.modalId} #title`).innerText = 'Do you want to delete all history ?'
            }
        }
    }

    async performHistoryDelete() {
        // delete all history or specific history id if the parameter is set in this class
        if (this.targetHistoryId !== undefined) {
            const response = await RequestPost.send('./php/file.php', {historyId: this.targetHistoryId}, 'performHistoryDelete')

            if (response['dataDeleted']) {
                // remove row from table
                Tbl_FailedLogins.deleteRowById(this.targetHistoryId)

                // check if table still have rows
                if (Tbl_FailedLogins.rowsCount()) {
                    // reindex table rows
                    Tbl_FailedLogins.reindexRows()
                }
                else {
                    // show no results row
                    Tbl_FailedLogins.showNoResultsRow()

                    // hide delete all history button
                    buttonDeleteAllHistory.shown(false)
                }


                // close modal
                this.shown(false)

                Swal.fire({
                    icon: 'success',
                    title: 'Great!',
                    html: `History has been deleted successfully`,
                    allowOutsideClick: true,
                    confirmButtonText: 'Ok'
                })
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
        }
        else {
            const response = await RequestPost.send('./php/file.php', {}, 'performAllHistoryDelete')

            if (response['dataDeleted']) {
                // clear table rows
                Tbl_FailedLogins.clearRows()

                // show no results
                Tbl_FailedLogins.showNoResultsRow()

                // hide delete all history button
                buttonDeleteAllHistory.shown(false)

                // close modal
                this.shown(false)

                Swal.fire({
                    icon: 'success',
                    title: 'Great!',
                    html: `Histories have been deleted successfully`,
                    allowOutsideClick: true,
                    confirmButtonText: 'Ok'
                })
            } else {
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
        }
    }
}

export default new Modal_DeleteHistory()