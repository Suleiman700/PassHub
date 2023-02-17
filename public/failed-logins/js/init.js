// data
import Data_FailedLogins from './data/Data_FailedLogins.js';

// tables
import Tbl_FailedLogins from './tables/Tbl_FailedLogins.js';

async function prepareCategoriesTable() {
    // get user categories
    await Data_FailedLogins.fetchCategories()

    // get fetched categories
    const fetchedLoginsHistory = Data_FailedLogins.dataGet()

    // check if categories found
    if (fetchedLoginsHistory.length) {
        for (const fetchedLoginHistory of fetchedLoginsHistory) {
            Tbl_FailedLogins.rowAdd(fetchedLoginHistory)
        }
    } else {
        Tbl_FailedLogins.showNoResultsRow()
    }
}

await prepareCategoriesTable()

$('.loader-wrapper').fadeOut('fast', function() {
    $(this).remove();
});