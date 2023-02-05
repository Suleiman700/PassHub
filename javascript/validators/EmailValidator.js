
class EmailValidator {

    constructor() {}

    /**
     * receive email to be validated
     * @param _email {string} example: person@domain.com
     * @return {boolean}
     */
    validate(_email) {
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailRegex.test(_email);
    }

}

export default new EmailValidator()