
import RequestGet from '/javascript/requests/RequestGet.js';

class Data_SuccessfulLogins {
    #data = []

    constructor() {}

    async fetchCategories() {
        const response = await RequestGet.send('./php/file.php', {}, 'fetchSuccessfulLogins')

        // successful request
        if (response['dataFound']) {
            // store categories
            this.#data = response['data']
        }
        else {

        }
    }

    /**
     * get data
     * @return {array}
     */
    dataGet() {
        return this.#data;
    }

    /**
     * get data by key and value
     * @param _key {string} example: id
     * @param _value {string} example: 5
     * @return {object}}
     */
    dataGetKeyValue(_key, _value) {
        return this.#data.find(data => data[_key] == _value)
    }
}

export default new Data_SuccessfulLogins()