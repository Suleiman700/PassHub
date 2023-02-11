// data
import Data_Passwords from './data/Data_Passwords.js';

// tables
import Tbl_Passwords from './tables/Tbl_Passwords.js';

async function prepareCategoriesTable() {
    // get user categories
    await Data_Passwords.fetchPasswords()

    // get fetched categories
    const fetchedPasswords = Data_Passwords.dataGet()

    // check if categories found
    if (fetchedPasswords.length) {
        for (const fetchedPassword of fetchedPasswords) {
            Tbl_Passwords.rowAdd(fetchedPassword)
        }
    } else {
        Tbl_Passwords.showNoResultsRow()
    }
}

await prepareCategoriesTable()