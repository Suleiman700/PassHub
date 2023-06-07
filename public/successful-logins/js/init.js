// data
import Data_SuccessfulLogins from './data/Data_SuccessfulLogins.js';

// tables
import Tbl_SuccessfulLogins from './tables/Tbl_SuccessfulLogins.js';

// buttons
import buttonDeleteAllHistory from './buttons/button-delete-all-history.js';

async function prepareCategoriesTable() {
    // get user categories
    await Data_SuccessfulLogins.fetchCategories()

    // get fetched data
    const fetchedLoginsHistory = Data_SuccessfulLogins.dataGet()

    // check if data found
    if (fetchedLoginsHistory.length) {
        // show button to delete all history
        buttonDeleteAllHistory.shown(true)

        for (const fetchedCategory of fetchedLoginsHistory) {
            Tbl_SuccessfulLogins.rowAdd(fetchedCategory)
        }
    } else {
        // hide button to delete all history
        buttonDeleteAllHistory.shown(false)

        Tbl_SuccessfulLogins.showNoResultsRow()
    }
}

await prepareCategoriesTable()

$('.loader-wrapper').fadeOut('slow', function() {
    $(this).remove();
});