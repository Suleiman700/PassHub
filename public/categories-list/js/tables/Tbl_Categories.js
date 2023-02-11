
class Tbl_Categories {
    constructor() {
        this.tableId = 'categories-table'
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
        td.innerText = 'No Categories Found!'
        tr.append(td)

        tableTbody.append(tr)
    }
    /**
     * add category row into table
     * @param _categoryInfo {object}
     * @return {void}
     *
     * example of _categoryInfo:<br>
     * {<br>
     *     "id": "0",<br>
     *     "user_id": "0",<br>
     *     "name": "Family",<br>
     *     "description": "Family passwords"<br>
     * }<br>
     */
    rowAdd(_categoryInfo) {
        const row = this.#buildRow(_categoryInfo)

        // add row into table
        document.querySelector(`#${this.tableId} tbody`).appendChild(row)
    }

    /**
     * receive category info and build a row for it to be inserted into table
     * @param _categoryInfo
     */
    #buildRow(_categoryInfo) {
        const tr = document.createElement('tr')

        // index cell
        const cell_index = document.createElement('th')
        cell_index.innerText = this.#rowsCount() + 1
        cell_index.setAttribute('scope', 'row')
        tr.appendChild(cell_index)

        // name cell
        const cell_name = document.createElement('td')
        cell_name.innerText = _categoryInfo['name']
        cell_name.style.color = _categoryInfo['color']
        tr.appendChild(cell_name)

        // description cell
        const cell_description = document.createElement('td')
        cell_description.innerText = _categoryInfo['description']
        tr.appendChild(cell_description)

        // passwords count cell
        const cell_password_count = document.createElement('td')
        cell_password_count.innerText = _categoryInfo['passwords_count']
        tr.appendChild(cell_password_count)

        // options cell
        const cell_options = document.createElement('td')
        const button_edit = document.createElement('i')
        button_edit.classList.add('badge', 'badge-primary', 'fa', 'fa-edit')
        button_edit.style.cursor = 'pointer'
        button_edit.innerHTML = ' Edit'
        button_edit.addEventListener('click', () => {
            window.location.replace(`../categories-edit/index.php?id=${_categoryInfo['id']}`);
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

export default new Tbl_Categories()