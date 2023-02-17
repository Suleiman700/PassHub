// data
import Data_SuccessfulLogins from './data/Data_SuccessfulLogins.js';

// tables
import Tbl_SuccessfulLogins from './tables/Tbl_SuccessfulLogins.js';

async function prepareCategoriesTable() {
    // get user categories
    await Data_SuccessfulLogins.fetchCategories()

    // get fetched categories
    const fetchedLoginsHistory = Data_SuccessfulLogins.dataGet()

    // check if categories found
    if (fetchedLoginsHistory.length) {
        for (const fetchedCategory of fetchedLoginsHistory) {
            Tbl_SuccessfulLogins.rowAdd(fetchedCategory)
        }
    } else {
        Tbl_SuccessfulLogins.showNoResultsRow()
    }
}

await prepareCategoriesTable()

$('.loader-wrapper').fadeOut('fast', function() {
    $(this).remove();
});