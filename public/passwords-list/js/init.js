// data
import Data_Passwords from './data/Data_Passwords.js';

// tables
import Tbl_Passwords from './tables/Tbl_Passwords.js';

async function prepareCategoriesTable() {
    // get user categories
    const response = await Data_Passwords.fetchPasswords()


    // check if categories found
    if (response['dataFound']) {
        // get fetched categories
        const fetchedPasswords = Data_Passwords.dataGet()

        for (const fetchedPassword of fetchedPasswords) {
            Tbl_Passwords.rowAdd(fetchedPassword)
        }
    } else {
        Tbl_Passwords.showNoResultsRow()

        // show error
        Swal.fire({
            icon: 'error',
            title: 'Ops...',
            html:
                response['errors'].map(error => {
                    return `
                            <div>
                                <h6>${error['error']}</h6>
                                <h6>Error Code: ${error['errorCode']}</h6>
                            </div>
                        `;
                }).join('')
        })
    }
}

await prepareCategoriesTable()