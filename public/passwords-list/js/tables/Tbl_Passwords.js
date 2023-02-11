
import CopyToClipboard from '/javascript/helpers/CopyToClipboard.js';

class Tbl_Passwords {
    constructor() {
        this.tableId = 'passwords-table'
    }

    /**
     * show no results row
     * @return {void}
     */
    showNoResultsRow() {
        // clear table rows
        this.#clearRows()

        // show row
        const tableTbody = document.querySelector(`#${this.tableId} tbody`)

        const tr = document.createElement('tr')
        const td = document.createElement('td')
        td.setAttribute('colspan', '100%')
        td.innerText = 'No Passwords Found!'
        tr.append(td)

        tableTbody.append(tr)
    }
    /**
     * add category row into table
     * @param _passwordInfo {object}
     * @return {void}
     *
     * example of _passwordInfo:<br>
     * {<br>
     *     "id": "0",<br>
     *     "user_id": "0",<br>
     *     "name": "Family",<br>
     *     "description": "Family passwords"<br>
     * }<br>
     */
    rowAdd(_passwordInfo) {
        const row = this.#buildRow(_passwordInfo)

        // add row into table
        document.querySelector(`#${this.tableId} tbody`).appendChild(row)
    }

    /**
     * receive category info and build a row for it to be inserted into table
     * @param _passwordInfo
     */
    #buildRow(_passwordInfo) {
        const tr = document.createElement('tr')

        // index cell
        const cell_index = document.createElement('th')
        cell_index.innerText = this.#rowsCount() + 1
        cell_index.setAttribute('scope', 'row')
        tr.appendChild(cell_index)

        // username cell
        const cell_username = document.createElement('td')
        cell_username.innerText = _passwordInfo['username']
        cell_username.style.cursor = 'pointer'
        cell_username.addEventListener('click', () => {
            new CopyToClipboard(_passwordInfo['username'])
        })
        tr.appendChild(cell_username)

        // password cell
        const cell_password = document.createElement('td')
        const div = document.createElement('div')
        // --------------------------
        const input = document.createElement('input')
        input.setAttribute('type', 'password')
        input.setAttribute('disabled', 'disabled')
        input.classList.add('form-control', 'password')
        input.style.cursor = 'pointer'
        input.value = _passwordInfo['password']

        // wrap input with parent because we cannot add click event to disabled input
        const inputParent = document.createElement('div')
        inputParent.addEventListener('click', () => {
            new CopyToClipboard(_passwordInfo['password'])
        })
        inputParent.append(input)
        div.appendChild(inputParent)
        // --------------------------
        const icon = document.createElement('span')
        icon.classList.add('fa', 'fa-fw', 'fa-eye', 'toggle-password-visibility-icon', 'toggle-password')
        icon.addEventListener('click', () => {
            if (input.getAttribute('type') == 'password') input.setAttribute('type', 'test')
            else input.setAttribute('type', 'password')
        })
        div.appendChild(icon)
        // --------------------------
        cell_password.appendChild(div)
        tr.appendChild(cell_password)

        // website cell
        const cell_website = document.createElement('td')
        cell_website.innerText = _passwordInfo['website']
        tr.appendChild(cell_website)

        // description cell
        const cell_description = document.createElement('td')
        cell_description.innerText = _passwordInfo['description']
        tr.appendChild(cell_description)

        // options cell
        const cell_options = document.createElement('td')
        const button_edit = document.createElement('i')
        button_edit.classList.add('badge', 'badge-primary', 'fa', 'fa-edit')
        button_edit.style.cursor = 'pointer'
        button_edit.innerHTML = ' Edit'
        button_edit.addEventListener('click', () => {
            window.location.replace(`../passwords-edit/index.php?id=${_passwordInfo['id']}`);
        })
        cell_options.append(button_edit)
        tr.appendChild(cell_options)

        return tr
    }

    /**
     * clear table rows
     * @return {void}
     */
    #clearRows() {
        document.querySelector(`#${this.tableId} tbody`).innerHTML = ''
    }

    /**
     * get the number of table rows
     * @return {number}
     */
    #rowsCount() {
        const rows = document.querySelectorAll(`#${this.tableId} tbody tr`)
        return rows.length
    }
}

export default new Tbl_Passwords()