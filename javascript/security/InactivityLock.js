
/*
    This class is used to enter Lock Mode when user in inactive for a specific time
 */

import EncryptionService from '/javascript/security/EncryptionService.js';

class InactivityLock {
    INACTIVITY_TIME_LIMIT = 600000 // 10 minutes
    lockMessage = undefined

    constructor() {
        this.enable()
    }

    enable() {
        // Get the current time in milliseconds
        let lastInteractionTime = Date.now();

        // Listen for mousemove and click events
        document.addEventListener("mousemove", () => {
            lastInteractionTime = Date.now();
        });

        document.addEventListener("click", () => {
            lastInteractionTime = Date.now();
        });

        // Check if the user has been inactive for the specified time limit
        setInterval(async () => {
            if (Date.now() - lastInteractionTime >= this.INACTIVITY_TIME_LIMIT) {
                window.location.href = `../lock-mode/index.php?message=${this.lockMessage}`
            }
        }, 1000);
    }

    /**
     * set message to be passed to the lock mode page
     * @param encryptedMessage {string}
     */
    setMessage(_encryptedMessage) {
        this.lockMessage = _encryptedMessage
    }
}


export default new InactivityLock()