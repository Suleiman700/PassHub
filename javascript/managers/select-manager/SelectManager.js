/*
    This class is responsible for managing select elements (NOT SELECT2!)
 */

export default class SelectManager {
    constructor(_parentId, _id, _cb=null) {
        this.parentId = _parentId
        this.id = _id
        this.cb = _cb

        // Store all options
        this.options = []

        // Store the selected option
        this.selectedOption = {
            value: undefined,
            text: undefined
        }
    }

    /**
     * Check if options are set
     * @returns {boolean}
     */
    areOptionsSet() {
        return !!this.options.length;
    }

    /**
     * Clear all options from the select
     */
    clearOptions() {
        $(`#${this.parentId} select#${this.id}`).empty()
    }

    /**
     * Deselect selected option
     */
    deselect() {
        $(`#${this.parentId} select#${this.id}`).val(null).trigger('change')
    }

    /**
     * Enable or disable the select
     * @param _option {Boolean}
     */
    enabled(_option) {
        document.querySelector(`#${this.parentId} select#${this.id}`).disabled = !_option
    }

    /**
     * Enable onChange event listener
     */
    enableOnChangeEvent() {
        document.querySelector(`#${this.parentId} select#${this.id}`).addEventListener('change', () => {
            this.selectedOption['value'] = this.get_selected_value()
            // this.selectedOption['text'] = this.get_selected_text()
            this.cb(this)
        })
    }

    /**
     * Put options into select
     * @param _options {Object}
     * @param _value {string} > The key to save for selected['id']
     * @param _text {string} > The key to save for selected['text']
     */
    put_options(_options, _value, _text) {
        // Clear all select options
        this.clearOptions()

        for (const option of _options) {
            const newOption = new Option(option[_text], option[_value], false, false);
            $(`#${this.parentId} select#${this.id}`).append(newOption)
        }

        // Deselect selected option
        this.deselect()

        // Save passed select options
        this.saveOptions(_options)
    }

    /**
     * Save select options
     * @param _options {object}
     */
    saveOptions(_options) {
        this.options = _options
    }

    /**
     * Set selected option by value
     * @param _value {string|number}
     */
    set_selected_option_by_value(_value) {
        document.querySelector(`#${this.parentId} select#${this.id}`).value = _value
        document.querySelector(`#${this.parentId} select#${this.id}`).dispatchEvent(new Event('change'));
    }

    /**
     * Get selected option's value
     * @return {string}
     */
    get_selected_value() {
        return document.querySelector(`#${this.parentId} select#${this.id}`).value
    }

    /**
     * Get selected option's text
     * @return {string}
     */
    get_selected_text() {
        const select = document.querySelector(`#${this.parentId} select#${this.id}`);
        return select.options[select.selectedIndex].text
    }
}