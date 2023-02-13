// data
import Data_Passwords from './data/Data_Passwords.js';

// tables
import Tbl_Passwords from './tables/Tbl_Passwords.js';

// search
import Search from './search/Search.js';

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

        /*
            extract categories ids and names from fetched passwords and put them into filter categories
            we can extract categories from fetches password instead of sending request to the server

            example of categories array:
            [
                {
                    "id": "0",
                    "name": "Friends"
                }
            ]
         */
        const categories = []
        for (const fetchedPassword of fetchedPasswords) {
            const category = {
                id: fetchedPassword['category_id'],
                name: fetchedPassword['category_name']
            }
            categories.push(category)
        }
        // since multiple passwords can have the same category id and category name, this code will remove duplications
        const uniqueCategories = [...new Set(categories.map(category => JSON.stringify(category)))].map(category => JSON.parse(category));
        Search.putCategoriesIntoSelect(uniqueCategories)
    } else {
        Tbl_Passwords.showNoResultsRow()

        // show error if set to true
        if (response['showErrors']) {
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
}

await prepareCategoriesTable()

$('.loader-wrapper').fadeOut('fast', function() {
    $(this).remove();
});