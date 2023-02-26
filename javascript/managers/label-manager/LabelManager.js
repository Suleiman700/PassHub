export default class LabelBuilder {
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
            console.error(`[LabelBuilder] Label #${this.id} does not exist in parent #${this.parentId}`)
            return false
        }
    }

    /**
     * Set label text
     * @param _text {string}
     */
    setText(_text) {
        document.querySelector(`#${this.parentId} #${this.id}`).innerText = _text
    }
}