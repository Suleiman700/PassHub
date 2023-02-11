
import RequestGet from '/javascript/requests/RequestGet.js';

class Data_Passwords {
    #categories = []

    constructor() {}

    async fetchPasswords() {
        const response = await RequestGet.send('./php/file.php', {}, 'fetchPasswords')

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

export default new Data_Passwords()