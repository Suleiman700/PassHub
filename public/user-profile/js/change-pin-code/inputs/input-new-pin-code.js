import InputManager from "../../../../../javascript/managers/input-manager/InputManager.js";

const inputNewPinCode = new InputManager('section-change-pin-code', 'new-pin-code')

inputNewPinCode.setAcceptDigitsOnly()

export default inputNewPinCode