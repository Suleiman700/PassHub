
class PinCodeValidator {

    constructor() {}

    /**
     * receive pin code to be validated
     * @param _pinCode {number} example: 123456
     * @return {boolean}
     */
    validate(_pinCode) {
        if (/^\d+$/.test(_pinCode) && _pinCode.toString().length === 4) {
            return true
        }
        else {
            return false
        }
    }

}

export default new PinCodeValidator()