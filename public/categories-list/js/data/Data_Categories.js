
import RequestGet from '/javascript/requests/RequestGet.js';

class Data_Categories {
    #categories = []

    constructor() {}

    async fetchCategories() {
        const response = await RequestGet.send('./php/file.php', {}, 'fetchCategories')

        // successful request
        if (response['dataFound']) {
            // store categories
            this.#categories = response['data']
        }
        else {

        }
    }

    /**
     * get data
     * @return {array}
     */
    dataGet() {
        return this.#categories;
    }
}

export default new Data_Categories()