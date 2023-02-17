
class Tbl_FailedLogins {
    constructor() {
        this.tableId = 'failed-logins-table'
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
        td.innerText = 'No History Found!'
        tr.append(td)

        tableTbody.append(tr)
    }
    /**
     * add category row into table
     * @param _loginHistoryInfo {object}
     * @return {void}
     *
     * example of _loginHistoryInfo:<br>
     * {<br>
     *     "ip_address": "x.x.x.x",<br>
     *     "login_time": "2023-02-01 16:01:11",<br>
     * }<br>
     */
    rowAdd(_loginHistoryInfo) {
        const row = this.#buildRow(_loginHistoryInfo)

        // add row into table
        document.querySelector(`#${this.tableId} tbody`).appendChild(row)
    }

    /**
     * receive login history info and build a row for it to be inserted into table
     * @param _loginHistoryInfo
     */
    #buildRow(_loginHistoryInfo) {
        const tr = document.createElement('tr')

        // index cell
        const cell_index = document.createElement('th')
        cell_index.innerText = this.#rowsCount() + 1
        cell_index.setAttribute('scope', 'row')
        tr.appendChild(cell_index)

        // used password cell
        const cell_usedPassword = document.createElement('td')
        cell_usedPassword.innerText = _loginHistoryInfo['used_password']
        tr.appendChild(cell_usedPassword)

        // used pin code cell
        const cell_usedPinCode = document.createElement('td')
        cell_usedPinCode.innerText = _loginHistoryInfo['used_pin_code']
        tr.appendChild(cell_usedPinCode)

        // used fail reason
        const cell_failReason = document.createElement('td')
        cell_failReason.innerText = _loginHistoryInfo['fail_reason']
        cell_failReason.style.whiteSpace = 'pre'
        tr.appendChild(cell_failReason)

        // ip address cell
        const cell_ipAddress = document.createElement('td')
        cell_ipAddress.innerHTML = _loginHistoryInfo['ip_address']
        cell_ipAddress.style.whiteSpace = 'pre'
        // check current user ip address
        if (_loginHistoryInfo['ip_address'] === document.querySelector('#current-user-ip-address').value) {
            cell_ipAddress.innerHTML += ' <span class="text-success">[This IP]</span>'
        }
        tr.appendChild(cell_ipAddress)

        // time cell
        const cell_time = document.createElement('td')
        cell_time.innerText = _loginHistoryInfo['login_time']
        cell_time.style.wordBreak = 'break-word'
        tr.appendChild(cell_time)

        // user agent cell
        const cell_userAgent = document.createElement('td')
        cell_userAgent.innerText = _loginHistoryInfo['user_agent']
        tr.appendChild(cell_userAgent)

        // options cell
        const cell_options = document.createElement('td')
        const button_edit = document.createElement('i')
        button_edit.classList.add('badge', 'badge-danger', 'fa', 'fa-trash')
        button_edit.style.cursor = 'pointer'
        button_edit.innerHTML = ' Delete'
        button_edit.addEventListener('click', () => {
            console.log('clicked')
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

export default new Tbl_FailedLogins()