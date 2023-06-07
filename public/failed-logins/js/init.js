// data
import Data_FailedLogins from './data/Data_FailedLogins.js';

// tables
import Tbl_FailedLogins from './tables/Tbl_FailedLogins.js';

// buttons
import buttonDeleteAllHistory from './buttons/button-delete-all-history.js';

async function prepareCategoriesTable() {
    // get user categories
    await Data_FailedLogins.fetchCategories()

    // get fetched data
    const fetchedLoginsHistory = Data_FailedLogins.dataGet()

    // check if data found
    if (fetchedLoginsHistory.length) {
        // show button to delete all history
        buttonDeleteAllHistory.shown(true)

        for (const fetchedLoginHistory of fetchedLoginsHistory) {
            Tbl_FailedLogins.rowAdd(fetchedLoginHistory)
        }
    } else {
        // hide button to delete all history
        buttonDeleteAllHistory.shown(false)

        Tbl_FailedLogins.showNoResultsRow()
    }
}

await prepareCategoriesTable()

$('.loader-wrapper').fadeOut('slow', function() {
    $(this).remove();
});