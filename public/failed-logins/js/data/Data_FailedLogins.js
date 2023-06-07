
import RequestGet from '../../../../javascript/requests/RequestGet.js';

class Data_FailedLogins {
    #data = []

    constructor() {}

    async fetchCategories() {
        const response = await RequestGet.send('./php/file.php', {}, 'fetchFailedLogins')

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
}

export default new Data_FailedLogins()