export default class EncryptionService {
    constructor() {
        // Generate a random encryption key
        this.encryptionKey = null;
        const keyPromise = crypto.subtle.importKey(
            'raw',
            new Uint8Array([0x2a, 0x57, 0xa1, 0x0c, 0x8e, 0x99, 0x2d, 0x31, 0x04, 0x0d, 0x92, 0x74, 0xe7, 0x1c, 0x54, 0x3b]),
            {name: 'AES-CBC'},
            true,
            ['encrypt', 'decrypt']
        );
        keyPromise.then((key) => {
            this.encryptionKey = key;
        });
    }

    // Encrypt a message with the key
    async encryptMessage(message) {
        await this.waitForKey();
        const encodedMessage = new TextEncoder().encode(message);
        const iv = crypto.getRandomValues(new Uint8Array(16));
        const algorithm = { name: 'AES-CBC', iv: iv };
        const encryptedMessage = await crypto.subtle.encrypt(algorithm, this.encryptionKey, encodedMessage);
        const encryptedArray = new Uint8Array(encryptedMessage);
        const combinedArray = new Uint8Array(iv.length + encryptedArray.length);
        combinedArray.set(iv);
        combinedArray.set(encryptedArray, iv.length);
        return btoa(String.fromCharCode.apply(null, combinedArray));
    }

    // Decrypt a message with the key
    async decryptMessage(encryptedMessage) {
        await this.waitForKey();
        const combinedArray = new Uint8Array(atob(encryptedMessage).split("").map(c => c.charCodeAt(0)));
        const iv = combinedArray.slice(0, 16);
        const encryptedArray = combinedArray.slice(16);
        const algorithm = { name: 'AES-CBC', iv: iv };
        const decryptedMessage = await crypto.subtle.decrypt(algorithm, this.encryptionKey, encryptedArray);
        return new TextDecoder().decode(decryptedMessage);
    }

    // Wait for the encryption key to be generated
    async waitForKey() {
        while (!this.encryptionKey) {
            await new Promise(resolve => setTimeout(resolve, 100));
        }
    }
}