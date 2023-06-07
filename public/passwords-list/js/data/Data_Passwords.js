
import RequestGet from '../../../../javascript/requests/RequestGet.js';

class Data_Passwords {
    #passwords = []

    constructor() {}

    async fetchPasswords() {
        const response = await RequestGet.send('./php/file.php', {}, 'fetchPasswords')

        // successful request
        if (response['dataFound']) {
            // store categories
            this.#passwords = response['data']
        }

        return response
    }

    /**
     * get data
     * @return {array}
     */
    dataGet() {
        return this.#passwords;
    }
}

export default new Data_Passwords()