export default class AlertManager {

    #alertColor = 'danger' // store the color of the alert

    constructor(_parentId, _id) {
        this.parentId = _parentId
        this.id = _id

        // Check if element exists
        this.doesExist()
    }

    /**
     * Check if element exists
     * @returns {boolean}
     */
    doesExist() {
        if (document.querySelector(`#${this.parentId} #${this.id}`) !== null) {
            return true
        }
        else {
            console.error(`[AlertManager] Alert #${this.id} does not exist in parent #${this.parentId}`)
            return false
        }
    }

    /**
     * set the color of the alert
     * @param _color
     */
    colorSet(_color) {
        const allowedColors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark']

        // check color
        if (allowedColors.includes(_color)) {
            const $alert = document.querySelector(`#${this.parentId} div#${this.id}`)
            $alert.classList = `alert alert-${_color}`
        }
        else {
            console.error(`[AlertManager] Unsupported color.\nAvailable colors: ${allowedColors.toString()}`)
        }

    }

    /**
     * Enable or disable the input
     * @param _option {Boolean}
     */
    shown(_option) {
        if (_option) {
            document.querySelector(`#${this.parentId} div#${this.id}`).style.display = 'block'
        }
        else {
            document.querySelector(`#${this.parentId} div#${this.id}`).style.display = 'none'
        }
    }

    /**
     * Set the value of the alert
     * @param _value {[]} can be text or html
     */
    valueSet(_value) {
        // $: indicates that is it an element
        const $alert = document.querySelector(`#${this.parentId} div#${this.id}`)

        // clear values before inserting new values
        $alert.innerHTML = ''

        // build values to be inserted into the alert
        const div = document.createElement('div')
        _value.forEach(value => {
            const p = document.createElement('p')
            p.innerHTML = value
            div.appendChild(p)
        })

        // Set value
        $alert.append(div)
    }

}