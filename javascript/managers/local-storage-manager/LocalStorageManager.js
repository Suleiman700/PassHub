
class LocalStorageManager {

    itemPrefix = 'PASSHUB_LS'

    constructor() {}

    /**
     * set light mode
     * @param _lightMode {string} E.g. dark | light
     */
    setLightMode(_lightMode) {
        localStorage.setItem(`${this.itemPrefix}_LIGHT_MODE`, _lightMode)
    }

    /**
     * get light mode
     * @return {string} E.g. dark | light
     */
    getLightMode() {
        return localStorage.getItem(`${this.itemPrefix}_LIGHT_MODE`)
    }
}

export default new LocalStorageManager()